<?php

namespace App\Http\Controllers;

use App\Models\HelpCenter;
use Illuminate\Http\Request;

class HelpCenterController extends Controller
{
    public function index()
    {
        $helps = HelpCenter::all(); // Ambil semua data help center
        return view('help-center.index', compact('helps'));
    }
}
