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

class authcontroller extends Controller
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
        ]);

        if ($validator->fails()) {
            return redirect()->route('auth.login')
                ->withErrors($validator)
                ->withInput();
        }

        // Attempt to login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('home')->with('success', 'Login berhasil');
        }

        Alert::errors('Error', 'Email atau Passowrd anda tidak terdaftar');
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
            Auth::login($existingUser);

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
            'password' => 'required|string|min:5|confirmed',
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
        return redirect('/login');
    }
}
