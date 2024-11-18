<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    
    public function beranda()
    {
        // Mendapatkan semua data pengguna dari database
        $users = DB::table('users')->select('name', 'email')->get();

        // Menghitung total pengguna
        $totalUsers = $users->count();

        // Mengirimkan data ke view
        return view('admin.beranda', compact('users', 'totalUsers'));
    }

    public function kelola()
    {
        return view('admin/kelola');
    }

    public function detail()
    {
        return view('admin/detail');
    }

    public function tambah()
    {
        return view('admin/tambah');
    }
}
