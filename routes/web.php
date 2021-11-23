<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ReplyController;

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

Route::redirect('/', '/thread');
Route::resource('/thread', ThreadController::class);
Route::resource('/reply', ReplyController::class);
Route::post('/thread/search', [ThreadController::class, 'search'])->name('thread.search');
