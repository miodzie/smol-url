<?php

use App\Http\Controllers\TinyUrlController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [TinyUrlController::class, 'create']);
Route::get('/{any}', [TinyUrlController::class, 'findAndRedirect']);
Route::resource('tiny-urls', TinyUrlController::class);
