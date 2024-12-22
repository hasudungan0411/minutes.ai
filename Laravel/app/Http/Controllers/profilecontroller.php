<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class profilecontroller extends Controller // Perbaiki nama kelas
{
    // Menampilkan halaman edit profil
    public function edit()
    {
        return view('profile'); // Menampilkan form pembaruan profil
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
        return redirect('/profile');
    }
}
