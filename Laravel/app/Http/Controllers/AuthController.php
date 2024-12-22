<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:5',
        ], [
            'email.required' => 'Email wajib di isi',
            'password.required' => 'Password wajib diisi'
        ]);

        if ($validator->fails()) {
            return redirect()->route('auth.login')
                ->withErrors($validator)
                ->withInput();
        }

        // Attempt to login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Perbarui waktu terakhir login
            $user = Auth::user();
            $user->last_login = now(); // Gunakan Carbon untuk mendapatkan waktu saat ini
            $user->save();

            // Redirect sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.beranda')->with('success', 'Login berhasil');
            } else {
                return redirect()->route('home')->with('success', 'Login berhasil');
            }
        }

        Alert::errors('Error', 'Email atau Password anda tidak terdaftar');
        return redirect('/login');
    }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $existingUser = User::where('email', $user->getEmail())->first();

        if ($existingUser) {
            // Login user yang sudah ada
            Auth::login($existingUser);

            // Perbarui waktu terakhir login
            $existingUser->last_login = now(); // Gunakan Carbon untuk waktu saat ini
            $existingUser->save();

            Alert::success('success', 'Anda Berhasil Login');
            return redirect()->route('home')->with('success', 'Login berhasil dengan Google');
        }

        // Jika pengguna belum terdaftar, buat pengguna baru
        $newUser = User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => Hash::make(Str::random(16)), // Generate a random password for new users
            'fotoprofil' => $user->getAvatar() ?? 'default_avatar_url',
            'google_id' => $user->getId(), // Store Google ID if needed
        ]);

        Auth::login($newUser);

        // Perbarui waktu terakhir login untuk user baru
        $newUser->last_login = now();
        $newUser->save();

        Alert::success('success', 'Anda Berhasil Login');
        return redirect('home');
    }


    public function register()
    {
        return view('auth.register');
    }

    public function registerPost(Request $request)
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
                'confirmed'
            ],
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Kata sandi wajib diisi',
            'password.min' => 'Kata sandi harus minimal 8 karakter',
            'password.regex' => 'Kata sandi harus mengandung huruf kecil, huruf kapital, dan angka',
            'password.confirmed' => 'Kata sandi tidak sama',
        ]);

        if ($validator->fails()) {
            return redirect()->route('auth.register')
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Alert::success('success', 'Anda Berhasil Membuat Akun');
        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Alert::success('success', 'Anda Berhasil Logout');
        return redirect('/');
    }
}
