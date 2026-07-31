<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ParasitoController;

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