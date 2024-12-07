<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\controllerhome;
use App\Http\Controllers\caraPenggunaan;
use App\Http\Controllers\profile;
use App\Http\Controllers\detail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [controllerhome::class, 'home']);
Route::get('/caraPenggunaan', [caraPenggunaan::class, 'caraPenggunaan']);
Route::get('/profile', [profile::class, 'profile']);
Route::get('/detail', [detail::class, 'detail']);
