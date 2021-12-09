<?php

use App\Http\Controllers\API\TinyUrlController;
use Illuminate\Http\Request;
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

Route::get('/tiny-url', [TinyUrlController::class, 'all']);
Route::post('/tiny-url', [TinyUrlController::class, 'store']);
Route::delete('tiny-url', [TinyUrlController::class, 'delete']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
