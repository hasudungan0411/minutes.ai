<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authcontroller;
use App\Http\Controllers\controllerhome;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\audiocontroller;
use App\Http\Controllers\halamancontroller;
use App\Http\Controllers\profilecontroller;

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


Route::get('home', [controllerhome::class, 'home'])->name('home');
Route::get('/', [halamancontroller::class, 'halaman']);
Route::get('Cara-penggunaan', [controllerhome::class, 'caraPenggunaan']);
Route::get('detail', [controllerhome::class, 'detail'])->name('detail');

Route::get('/login', [authcontroller::class, 'login'])->name('auth.login');
Route::post('/login', [authcontroller::class, 'loginpost'])->name('auth.login.post');
Route::get('/auth/google', [authcontroller::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/notulain/auth/callback', [authcontroller::class, 'handleGoogleCallback']);
Route::POST('/auth/logout', [authcontroller::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/register', [authcontroller::class, 'register'])->name('auth.register');
Route::post('/register', [authcontroller::class, 'registerpost'])->name('auth.register.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [profilecontroller::class, 'edit'])->name('userprofile');
    Route::put('/profile/update', [profilecontroller::class, 'update'])->name('profile.update');
});

/* Halaman Admin*/
Route::get('admin/beranda', [AdminController::class, 'beranda'])->name('admin.beranda');
Route::post('/admin/tambah-user', [AdminController::class, 'tambahUser'])->name('admin.tambahUser');
Route::delete('/admin/hapus-user/{id}', [AdminController::class, 'hapusUser'])->name('admin.hapusUser');
Route::get('admin/kelola', [AdminController::class, 'kelola'])->name('admin.kelola');
Route::get('admin/detail', [AdminController::class, 'detail']);
Route::get('admin/tambah', [AdminController::class, 'tambah']);


Route::post('/upload-audio', [audiocontroller::class, 'upload'])->name('upload.audio');
