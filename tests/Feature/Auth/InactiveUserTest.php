<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InactiveUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_inactive_users_cannot_log_in_even_with_remember_me(): void
    {
        $user = User::factory()->create(['activo' => false]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember' => true,
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_deactivated_users_lose_their_existing_session_before_a_write(): void
    {
        $user = User::factory()->create(['activo' => true]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticated();
        $user->update(['activo' => false]);

        // Simulate the next request loading the current user from the database.
        $this->app['auth']->forgetGuards();

        $this->patch('/profile', [
            'name' => 'Changed name',
            'email' => $user->email,
        ])->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'activo' => false,
        ]);
    }

    public function test_inactive_sessions_receive_a_json_error(): void
    {
        $user = User::factory()->create(['activo' => false]);

        $this->actingAs($user)->patchJson('/profile', [
            'name' => 'Changed name',
            'email' => $user->email,
        ])->assertForbidden()
            ->assertJson(['message' => 'Su cuenta está desactivada.']);

        $this->assertGuest();
        $this->assertSame($user->name, $user->fresh()->name);
    }

    public function test_a_remember_me_cookie_cannot_restore_access_for_an_inactive_user(): void
    {
        $user = User::factory()->create(['activo' => false]);
        $guard = $this->app['auth']->guard('web');
        $recaller = implode('|', [$user->id, $user->remember_token, $user->password]);

        $this->withCookie($guard->getRecallerName(), $recaller)
            ->get('/profile')
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_reactivated_users_can_log_in_again(): void
    {
        $user = User::factory()->create(['activo' => false]);
        $user->update(['activo' => true]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/dashboard')->assertSessionHasNoErrors();

        $this->assertAuthenticatedAs($user);
    }

    public function test_active_users_can_still_update_their_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->patch('/profile', [
            'name' => 'Changed name',
            'email' => $user->email,
        ])->assertRedirect('/profile')->assertSessionHasNoErrors();

        $this->assertAuthenticatedAs($user);
        $this->assertSame('Changed name', $user->fresh()->name);
    }
}
