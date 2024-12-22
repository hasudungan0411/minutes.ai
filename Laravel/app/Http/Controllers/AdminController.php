<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;


class AdminController extends Controller
{

    public function beranda()
{
    // Mengambil semua pengguna dengan role 'user' dan membatasi 10 per halaman
    $users = User::select('id', 'name', 'email', 'last_login')
                 ->where('role', 'user')
                 ->paginate(10); // Tambahkan pagination

    // Menghitung total pengguna dengan role 'user'
    $totalUsers = User::where('role', 'user')->count();

    // Menghitung jumlah pengguna dengan role 'user' yang pernah login
    $loggedInUsers = User::where('role', 'user')
                         ->whereNotNull('last_login')
                         ->count();

    // Kirim data ke view
    return view('admin.beranda', compact('users', 'totalUsers', 'loggedInUsers'));
}



    public function tambahUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/', // harus mengandung huruf kecil
                'regex:/[A-Z]/', // harus mengandung huruf kapital
                'regex:/[0-9]/', // harus mengandung angka
            ],
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Kata sandi wajib diisi',
            'password.min' => 'Kata sandi harus minimal 8 karakter',
            'password.regex' => 'Kata sandi harus mengandung huruf kecil, huruf kapital, dan angka',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.beranda')
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Alert::success('success', 'Anda Berhasil Menambahkan user baru');
        return redirect('/admin/beranda');
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

    public function edit()
    {
        return view('admin/profile'); // Menampilkan form pembaruan profil
    }

    // Memproses pembaruan profil
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'fotoprofil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama pengguna wajib diisi',
            'email.required' => 'Email pengguna wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
            'email.email' => 'Email tidak valid',
            'fotoprofil.image' => 'Format gambar tidak sesuai',
            'fotoprofil.mimes' => 'Format gambar tidak sesuai',
            'fotoprofil.max' => 'Ukuran gambar melebihi kapasitas, max 2 mb',
        ]);

        $user = User::find(Auth::id());
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->hasFile('fotoprofil')) {
            // Menghapus foto profil yang lama jika ada
            if ($user->fotoprofil) {
                File::delete(public_path($user->fotoprofil));
            }

            // Menyimpan foto profil baru
            $file = $request->file('fotoprofil');
            $filename = time() . '_' . $file->getClientOriginalName(); // Menggunakan nama unik
            $destinationPath = public_path('fotoprofil');

            // Pindahkan file ke folder public/fotoprofil
            $file->move($destinationPath, $filename);

            // Simpan path relatif ke database
            $user->fotoprofil = 'fotoprofil/' . $filename;
        }

        // Gunakan save() untuk menyimpan semua perubahan, termasuk fotoprofil
        $user->save();

        Alert::success('success', 'Profile berhasil diupdate');
        return redirect('/admin/beranda');
    }
}
