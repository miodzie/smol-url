<?php

use App\Http\Controllers\TinyURLController;
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

Route::get('/', [TinyURLController::class, 'create']);
Route::get('/{any}', [TinyURLController::class, 'findAndRedirect']);
Route::resource('short-urls', TinyURLController::class);
