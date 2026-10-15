<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class SingleSessionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['session.driver' => 'database']);
    }

    public function test_new_login_blocks_the_previous_session_before_it_can_write(): void
    {
        $user = User::factory()->create();
        $firstSession = $this->loginInNewBrowser($user)->getCookie(config('session.cookie'))->getValue();
        $secondSession = $this->loginInNewBrowser($user)->getCookie(config('session.cookie'))->getValue();

        $this->useBrowser($firstSession);
        $this->patch('/profile', [
            'name' => 'Old browser',
            'email' => $user->email,
        ])->assertRedirect(route('login'));

        $this->assertGuest();
        $this->assertSame($user->name, $user->fresh()->name);

        $this->useBrowser($secondSession);
        $this->patch('/profile', [
            'name' => 'New browser',
            'email' => $user->email,
        ])->assertRedirect('/profile')->assertSessionHasNoErrors();

        $this->assertAuthenticatedAs($user);
        $this->assertSame('New browser', $user->fresh()->name);
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_different_accounts_can_remain_logged_in(): void
    {
        $firstUser = User::factory()->create();
        $secondUser = User::factory()->create();
        $firstSession = $this->loginInNewBrowser($firstUser)->getCookie(config('session.cookie'))->getValue();
        $secondSession = $this->loginInNewBrowser($secondUser)->getCookie(config('session.cookie'))->getValue();

        foreach ([[$firstUser, $firstSession], [$secondUser, $secondSession]] as [$user, $session]) {
            $this->useBrowser($session);
            $this->patch('/profile', [
                'name' => $user->name,
                'email' => $user->email,
            ])->assertRedirect('/profile')->assertSessionHasNoErrors();
            $this->assertAuthenticatedAs($user);
        }
    }

    public function test_login_also_revokes_sessions_created_before_this_change(): void
    {
        $user = User::factory()->create();
        $session = $this->loginInNewBrowser($user)->getCookie(config('session.cookie'))->getValue();
        $row = DB::table('sessions')->where('id', $session)->first();
        $payload = json_decode(base64_decode($row->payload), true, flags: JSON_THROW_ON_ERROR);
        unset($payload['password_hash_web']);
        DB::table('sessions')->where('id', $session)->update([
            'payload' => base64_encode(json_encode($payload, JSON_THROW_ON_ERROR)),
        ]);

        $this->loginInNewBrowser($user);
        $this->assertDatabaseMissing('sessions', ['id' => $session]);

        $this->useBrowser($session);
        $this->patch('/profile', [
            'name' => 'Old browser',
            'email' => $user->email,
        ])->assertRedirect(route('login'));

        $this->assertGuest();
        $this->assertSame($user->name, $user->fresh()->name);
    }

    public function test_failed_login_does_not_disconnect_the_existing_session(): void
    {
        $user = User::factory()->create();
        $session = $this->loginInNewBrowser($user)->getCookie(config('session.cookie'))->getValue();

        $this->useBrowser();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->useBrowser($session);
        $this->patch('/profile', [
            'name' => $user->name,
            'email' => $user->email,
        ])->assertRedirect('/profile')->assertSessionHasNoErrors();

        $this->assertAuthenticatedAs($user);
    }

    public function test_previous_remember_cookie_cannot_restore_the_replaced_session(): void
    {
        $user = User::factory()->create();
        $cookieName = $this->app['auth']->guard('web')->getRecallerName();
        $cookie = $this->loginInNewBrowser($user, true)->getCookie($cookieName)->getValue();

        $this->loginInNewBrowser($user);

        $this->useBrowser();
        $this->withCookie($cookieName, $cookie)->get('/profile')
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_latest_remember_cookie_still_restores_its_session(): void
    {
        $user = User::factory()->create();
        $this->loginInNewBrowser($user, true);
        $cookieName = $this->app['auth']->guard('web')->getRecallerName();
        $cookie = $this->loginInNewBrowser($user, true)->getCookie($cookieName)->getValue();

        $this->useBrowser();
        $this->withCookie($cookieName, $cookie)->patch('/profile', [
            'name' => $user->name,
            'email' => $user->email,
        ])->assertRedirect('/profile')->assertSessionHasNoErrors();

        $this->assertAuthenticatedAs($user);
    }

    public function test_replaced_sessions_receive_an_unauthorized_json_response(): void
    {
        $user = User::factory()->create();
        $session = $this->loginInNewBrowser($user)->getCookie(config('session.cookie'))->getValue();
        $this->loginInNewBrowser($user);

        $this->useBrowser($session);
        $this->patchJson('/profile', [
            'name' => 'Old browser',
            'email' => $user->email,
        ])->assertUnauthorized();

        $this->assertGuest();
        $this->assertSame($user->name, $user->fresh()->name);
    }

    private function loginInNewBrowser(User $user, bool $remember = false): TestResponse
    {
        $this->useBrowser();

        return $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember' => $remember,
        ])->assertRedirect('/dashboard')->assertSessionHasNoErrors();
    }

    private function useBrowser(?string $sessionId = null): void
    {
        $this->app['auth']->forgetGuards();
        $this->app['session']->forgetDrivers();
        $this->app->forgetInstance('session.store');
        $this->app->forgetInstance('redirect');
        Redirect::clearResolvedInstance('redirect');
        $this->defaultCookies = [];
        $this->unencryptedCookies = [];

        foreach ($this->app['cookie']->getQueuedCookies() as $cookie) {
            $this->app['cookie']->unqueue($cookie->getName(), $cookie->getPath());
        }

        if ($sessionId !== null) {
            $this->withCookie(config('session.cookie'), $sessionId);
        }
    }
}
