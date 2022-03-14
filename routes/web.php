<?php

use App\Http\Controllers\ViewController;
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

Route::get('login', [ViewController::class, 'login']);
Route::get('dash', [ViewController::class, 'dash']);
Route::get('new', [ViewController::class, 'new']);
Route::get('edit', [ViewController::class, 'edit']);
Route::get('delete', [ViewController::class, 'delete']);
