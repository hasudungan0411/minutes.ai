<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;


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
        // Validasi Input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',  // Huruf kecil
                'regex:/[A-Z]/',  // Huruf besar
                'regex:/[0-9]/',  // Angka
                'confirmed',      // Konfirmasi password
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.regex' => 'Kata sandi harus mengandung huruf besar, huruf kecil, dan angka.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);
    
        // Jika Validasi Gagal
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();  // Mengembalikan form dengan pesan error
    }
        
        // Tambahkan User Baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Enkripsi password
        ]);
    
        // Redirect dengan Pesan Sukses
        return redirect()->route('admin.beranda')->with('tambahUserSuccess', 'User berhasil ditambahkan.');
    }    

   public function hapusUser($id)
{
    // Hapus user berdasarkan ID
    DB::table('users')->where('id', $id)->delete();

    return redirect()->route('admin.beranda')->with('hapusUserSuccess', 'User berhasil dihapus.');
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
