<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authcontroller;
use App\Http\Controllers\controllerhome;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\audiocontroller;
use App\Http\Controllers\halamancontroller;
use App\Http\Controllers\profilecontroller;
use App\Http\Controllers\DownloadSummaryController;

// Routes for users
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('home', [controllerhome::class, 'home'])->name('home');
});

// General routes
Route::get('/', [halamancontroller::class, 'halaman']);
Route::get('Cara-penggunaan', [controllerhome::class, 'caraPenggunaan'])->name('cara.penggunaan');
Route::get('detail/{id}', [controllerhome::class, 'detail'])->name('detail');

// Authentication routes
Route::get('/login', [authcontroller::class, 'login'])->name('auth.login');
Route::post('/login', [authcontroller::class, 'loginpost'])->name('auth.login.post');
Route::get('/auth/google', [authcontroller::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/notulain/auth/callback', [authcontroller::class, 'handleGoogleCallback']);
Route::POST('/auth/logout', [authcontroller::class, 'logout'])->name('logout')->middleware('auth');

// Registration routes
Route::get('/register', [authcontroller::class, 'register'])->name('auth.register');
Route::post('/register', [authcontroller::class, 'registerpost'])->name('auth.register.post');

// Profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [profilecontroller::class, 'edit'])->name('userprofile');
    Route::put('/profile/update', [profilecontroller::class, 'update'])->name('profile.update');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/beranda', [AdminController::class, 'beranda'])->name('admin.beranda');
    Route::post('/admin/tambah-user', [AdminController::class, 'tambahUser'])->name('admin.tambahUser');
    Route::post('/admin/user/store', [AdminController::class, 'store'])->name('admin.user.store');
    Route::delete('/admin/hapus-user/{id}', [AdminController::class, 'hapusUser'])->name('admin.hapusUser');
    Route::get('admin/kelola', [AdminController::class, 'kelola'])->name('admin.kelola');
    Route::get('admin/detail', [AdminController::class, 'detail']);
    Route::get('admin/tambah', [AdminController::class, 'tambah']);
    Route::get('/profile/admin', [AdminController::class, 'edit'])->name('adminprofile');
    Route::put('/profile/update/admin', [AdminController::class, 'update'])->name('profile.update.admin');
});

// Audio upload and processing routes
Route::post('/upload-audio', [audiocontroller::class, 'upload'])->name('upload.audio');
Route::post('/process-audio', [controllerhome::class, 'processAudio'])->name('process.audio');
Route::post('/process-recorded-audio', [controllerhome::class, 'processRecordedAudio']);
