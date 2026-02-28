<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class namaController extends Controller
{
    public function index()
    {
        return view('about'); // Akan memanggil file about.blade.php
    }
}