<?php

use App\Http\Controllers\AsistenteIaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapaEpidemiologicoController;
use App\Http\Controllers\ParasitoController;
use App\Http\Controllers\ParteParasitoController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');

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
    )->middlewareFor(['index', 'show'], 'can:ver parasitos')
        ->middlewareFor(['create', 'store'], 'can:crear parasitos')
        ->middlewareFor(['edit', 'update'], 'can:editar parasitos')
        ->middlewareFor('destroy', 'can:eliminar parasitos');

    Route::get('/parasitos/{parasito}/qr', [ParasitoController::class, 'qr'])
        ->name('parasitos.qr')->middleware('can:ver parasitos');

    Route::get('/parasitos/{parasito}/ficha', [ParasitoController::class, 'ficha'])
        ->name('parasitos.ficha')->middleware('can:ver parasitos');

    Route::get('/parasitos/{parasito}/pdf', [ParasitoController::class, 'pdf'])
        ->name('parasitos.pdf')->middleware('can:ver parasitos');

    Route::get(
        '/parasitos/{uuid}/visualizar',
        [ParasitoController::class, 'visualizar']
    )->name('parasitos.visualizar')->middleware('can:ver parasitos');

    /*
    |--------------------------------------------------------------------------
    | Usuarios
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'usuarios',
        UsuarioController::class
    )->middlewareFor(['index', 'show'], 'can:ver usuarios')
        ->middlewareFor(['create', 'store'], 'can:crear usuarios')
        ->middlewareFor(['edit', 'update'], 'can:editar usuarios')
        ->middlewareFor('destroy', 'can:eliminar usuarios');

    /*
    |--------------------------------------------------------------------------
    | Mapa Epidemiológico
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'mapa-epidemiologicos',
        MapaEpidemiologicoController::class
    )->middlewareFor(['index', 'show'], 'can:ver mapas')
        ->middlewareFor(['create', 'store'], 'can:crear mapas')
        ->middlewareFor(['edit', 'update'], 'can:editar mapas')
        ->middlewareFor('destroy', 'can:eliminar mapas');

    Route::delete(
        '/mapa-epidemiologicos/parasito/{parasito}',
        [MapaEpidemiologicoController::class, 'destroyPorParasito']
    )->name('mapa-epidemiologicos.destroyPorParasito')->middleware('can:eliminar mapas');

    Route::get(
        '/mapa-epidemiologicos/ver/{parasito}',
        [MapaEpidemiologicoController::class, 'show']
    )->name('mapa-epidemiologicos.show')->middleware('can:ver mapas');

    Route::get(
        '/mapa-prueba',
        function () {
            return view('mapa_epidemiologicos.mapa');
        }
    )->middleware('can:ver mapas');

    /*
    |--------------------------------------------------------------------------
    | Partes Anatómicas
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'parte-parasitos',
        ParteParasitoController::class
    )->middlewareFor(['index', 'show'], 'can:ver partes')
        ->middlewareFor(['create', 'store'], 'can:crear partes')
        ->middlewareFor(['edit', 'update'], 'can:editar partes')
        ->middlewareFor('destroy', 'can:eliminar partes');

    /*
    |--------------------------------------------------------------------------
    | Quiz
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'preguntas',
        PreguntaController::class
    )->middlewareFor(['index', 'show'], 'can:ver quiz')
        ->middlewareFor(['create', 'store'], 'can:crear quiz')
        ->middlewareFor(['edit', 'update'], 'can:editar quiz')
        ->middlewareFor('destroy', 'can:eliminar quiz');

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'roles',
        RolController::class
    )->middlewareFor(['index', 'show'], 'can:ver roles')
        ->middlewareFor(['create', 'store'], 'can:crear roles')
        ->middlewareFor(['edit', 'update'], 'can:editar roles')
        ->middlewareFor('destroy', 'can:eliminar roles');

    /*
    |--------------------------------------------------------------------------
    | Asistente IA
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/asistente-ia',
        [AsistenteIaController::class, 'index']
    )->name('asistente-ia.index')->middleware('can:ver asistente ia');

    Route::post(
        '/asistente-ia/preguntar',
        [AsistenteIaController::class, 'preguntar']
    )->name('asistente-ia.preguntar')->middleware('can:ver asistente ia');

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
