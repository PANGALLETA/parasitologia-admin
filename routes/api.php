<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\MapaController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\ParasitoController;
use App\Http\Controllers\Api\WebArController;

/*
|--------------------------------------------------------------------------
| API v1
|--------------------------------------------------------------------------
*/

Route::prefix('home')->group(function () {

    Route::get('/', [HomeController::class, 'index']);

});

Route::prefix('parasitos')->group(function () {

    Route::get('/', [ParasitoController::class, 'index']);

    Route::get('/{uuid}', [ParasitoController::class, 'show']);

});

Route::prefix('search')->group(function () {

    Route::get('/', [SearchController::class, 'index']);

});

Route::prefix('mapa')->group(function () {

    Route::get('/', [MapaController::class, 'index']);

    Route::get('/general', [MapaController::class, 'general']);

});

Route::prefix('quiz')->group(function () {

    Route::get('/{uuid}', [QuizController::class, 'index']);

});

Route::prefix('webar')->group(function () {

    Route::get('/{uuid}', [WebArController::class, 'show']);

});