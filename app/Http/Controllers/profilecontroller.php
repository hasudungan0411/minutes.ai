<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage; // Perbaiki penggunaan Storage

class profilecontroller extends Controller // Ubah nama kelas menjadi ProfileController
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
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->hasFile('fotoprofil')) {
            // Menghapus foto profil yang lama jika ada
            if ($user->fotoprofil) {
                Storage::disk('public')->delete($user->fotoprofil);
            }

            // Menyimpan foto profil baru
            $imagePath = $request->file('fotoprofil')->store('fotoprofil', 'public');
            $user->fotoprofil = 'storage/' . $imagePath;
        }

        $user->save();

        Alert::success('success', 'Profile berhasil diupdate');
        return redirect('/profile');
    }
}
