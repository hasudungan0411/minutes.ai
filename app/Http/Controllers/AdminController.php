<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function beranda()
    {
        return view('admin/beranda');
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
