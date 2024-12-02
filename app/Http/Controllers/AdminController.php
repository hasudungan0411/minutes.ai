<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class AdminController extends Controller
{
    
    public function beranda()
    {
        // Mengambil semua pengguna
        $users = User::select('id', 'name', 'email', 'last_login')->get();
    
        // Menghitung total pengguna
        $totalUsers = $users->count();
    
        // Menghitung jumlah pengguna yang pernah login
        $loggedInUsers = $users->whereNotNull('last_login')->count();
    
        // Kirim data ke view
        return view('admin.beranda', compact('users', 'totalUsers', 'loggedInUsers'));
    }

    public function tambahUser(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Simpan data user baru
    DB::table('users')->insert([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('admin.beranda')->with('success', 'User berhasil ditambahkan.');
}

public function store(Request $request)
{
    // Validasi Input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    // Simpan User Baru
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password), // Enkripsi password
    ]);

    // Redirect kembali ke halaman sebelumnya dengan pesan sukses
    return redirect()->route('admin.beranda')->with('success', 'User berhasil ditambahkan.');
}



public function hapusUser($id)
{
    // Hapus user berdasarkan ID
    DB::table('users')->where('id', $id)->delete();

    return redirect()->route('admin.beranda')->with('success', 'User berhasil dihapus.');
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
