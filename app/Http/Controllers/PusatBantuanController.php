<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PusatBantuanController extends Controller
{
    public function index()
    {
        return view('pusat-bantuan'); // Pastikan file view 'pusat-bantuan.blade.php' ada di resources/views
    }
}
