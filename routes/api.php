<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login',[\App\Http\Controllers\IniciarSesionController::class,'iniciar']);

Route::middleware(['jwt'])->group(function () {
    Route::resource('usuarios', \App\Http\Controllers\UsuariosController::class, ['except' => ['create', 'edit']]);
    Route::resource('articulos', \App\Http\Controllers\ArticulosController::class, ['except' => ['create', 'edit']]);
});
