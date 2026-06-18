<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParasitoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MapaEpidemiologicoController;
use App\Http\Controllers\ParteParasitoController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AsistenteIaController;
use App\Http\Controllers\RolController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Parásitos
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'parasitos',
        ParasitoController::class
    );

    Route::get(
        '/parasitos/{uuid}/visualizar',
        [ParasitoController::class, 'visualizar']
    )->name('parasitos.visualizar');

    /*
    |--------------------------------------------------------------------------
    | Usuarios
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'usuarios',
        UsuarioController::class
    );

    /*
    |--------------------------------------------------------------------------
    | Mapa Epidemiológico
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'mapa-epidemiologicos',
        MapaEpidemiologicoController::class
    );

    Route::delete(
        '/mapa-epidemiologicos/parasito/{parasito}',
        [MapaEpidemiologicoController::class, 'destroyPorParasito']
    )->name('mapa-epidemiologicos.destroyPorParasito');

    Route::get(
        '/mapa-epidemiologicos/ver/{parasito}',
        [MapaEpidemiologicoController::class, 'show']
    )->name('mapa-epidemiologicos.show');

    Route::get(
        '/mapa-prueba',
        function () {
            return view('mapa_epidemiologicos.mapa');
        }
    );

    /*
    |--------------------------------------------------------------------------
    | Partes Anatómicas
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'parte-parasitos',
        ParteParasitoController::class
    );

    /*
    |--------------------------------------------------------------------------
    | Quiz
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'preguntas',
        PreguntaController::class
    );

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'roles',
        RolController::class
    );

    /*
    |--------------------------------------------------------------------------
    | Asistente IA
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/asistente-ia',
        [AsistenteIaController::class, 'index']
    )->name('asistente-ia.index');

    Route::post(
        '/asistente-ia/preguntar',
        [AsistenteIaController::class, 'preguntar']
    )->name('asistente-ia.preguntar');

    /*
    |--------------------------------------------------------------------------
    | Perfil
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});

require __DIR__.'/auth.php';