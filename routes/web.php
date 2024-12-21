<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authcontroller;
use App\Http\Controllers\controllerhome;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\audiocontroller;
use App\Http\Controllers\halamancontroller;
use App\Http\Controllers\profilecontroller;
use App\Http\Controllers\DownloadSummaryController;

Route::middleware(['auth', 'role:user'])->group(function(){
    Route::get('home', [controllerhome::class, 'home'])->name('home');
});

Route::get('/', [halamancontroller::class, 'halaman']);
Route::get('Cara-penggunaan', [controllerhome::class, 'caraPenggunaan'])->name('cara.penggunaan');
Route::get('detail/{id}', [controllerhome::class, 'detail'])->name('detail');
Route::get('edit/{id}', [controllerhome::class, 'edit'])->name('edit');

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

/* Halaman Admin */
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/beranda', [AdminController::class, 'beranda'])->name('admin.beranda');
    Route::post('/admin/user/store', [AdminController::class, 'tambahUser'])->name('admin.user.store');
    Route::delete('/admin/hapus-user/{id}', [AdminController::class, 'hapusUser'])->name('admin.hapusUser');
    Route::get('admin/kelola', [AdminController::class, 'kelola'])->name('admin.kelola');
    Route::get('admin/detail', [AdminController::class, 'detail']);
    Route::get('admin/tambah', [AdminController::class, 'tambah']);
    Route::get('/profile/admin', [AdminController::class, 'edit'])->name('adminprofile');
    Route::put('/profile/update/admin', [AdminController::class, 'update'])->name('profile.update.admin');
});

Route::get('/transcripts/download/{id}', [DownloadSummaryController::class, 'download'])->name('transcripts.download');
Route::put('/transcript/update/{id}', [controllerhome::class, 'update'])->name('transcript.update');

Route::post('/upload-audio', [audiocontroller::class, 'upload'])->name('upload.audio');

Route::post('/process-audio', [controllerhome::class, 'processAudio'])->name('process.audio');

Route::post('/process-recorded-audio', [controllerhome::class, 'processRecordedAudio']);
