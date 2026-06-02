<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParasitoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MapaEpidemiologicoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::resource('parasitos', ParasitoController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('mapa-epidemiologicos',MapaEpidemiologicoController::class);
    Route::get('/mapa-prueba', function () {return view('mapa_epidemiologicos.mapa');});
    Route::delete('/mapa-epidemiologicos/parasito/{parasito}',[MapaEpidemiologicoController::class, 'destroyPorParasito'])->name('mapa-epidemiologicos.destroyPorParasito');
    Route::get('/mapa-epidemiologicos/ver/{parasito}',[MapaEpidemiologicoController::class, 'show'])->name('mapa-epidemiologicos.show');
    Route::get('/parasitos/{uuid}/visualizar',[ParasitoController::class, 'visualizar'])->name('parasitos.visualizar');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
