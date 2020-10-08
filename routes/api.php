<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('iniciar-sesion', [UsuarioController::class, 'login']);
Route::post('cerrar-sesion', [UsuarioController::class, 'logout'])->middleware('checkAutenticacion');
Route::post('registrarse', [UsuarioController::class, 'register']);

Route::middleware('checkAutenticacion')->get('/hola', function (Request $request) {
    return "hola"; 
});
