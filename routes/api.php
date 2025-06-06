<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/productos', function () {
    return response()->json([
        ['id' => 1, 'nombre' => 'Aceite 10W30', 'precio' => 45],
        ['id' => 2, 'nombre' => 'Filtro de aire', 'precio' => 20],
        ['id' => 3, 'nombre' => 'Batería 12V', 'precio' => 150],
    ]);
});
