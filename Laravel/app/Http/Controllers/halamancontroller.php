<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class halamancontroller extends Controller
{
    public function halaman()
    {
        return view('auth/halaman_utama');
    }
}
