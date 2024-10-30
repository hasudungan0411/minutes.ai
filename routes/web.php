<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\controllerhome;
use App\Http\Controllers\BerandaadminController;
use App\Http\Controllers\KelolamodelController;
use App\Http\Controllers\AdminController;

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



Route::get('home', [controllerhome::class, 'home']);


/* Halaman Admin*/
Route::get('admin/beranda', [AdminController::class, 'beranda'])->name('admin.beranda');
Route::get('admin/kelola', [AdminController::class, 'kelola'])->name('admin.kelola');
Route::get('admin/detail', [AdminController::class, 'detail']);
Route::get('admin/tambah', [AdminController::class, 'tambah']);



