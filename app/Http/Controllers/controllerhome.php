<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class controllerhome extends Controller
{
    public function home()
    {
        return view('home');
    }
}
