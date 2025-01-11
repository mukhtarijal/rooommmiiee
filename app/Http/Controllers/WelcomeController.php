<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Ambil data kost dengan relasi yang diperlukan
        $kosts = Kost::with([
            'durations' => function ($query) {
                $query->where('type', 'monthly'); // Ambil harga per bulan
            },
            'photos' => function ($query) {
                $query->where('type', 'kost')->take(1); // Ambil 1 foto dengan tipe kost
            },
            'facilities', // Ambil relasi fasilitas
        ])
            ->where('status', 'approved') // Hanya ambil kost yang statusnya approved
            ->where('is_premium', 1) // Hanya ambil kost yang is_premium = 1
            ->latest()
            ->get(); // Mengembalikan collection

        // Modifikasi data menggunakan each()
        $kosts->each(function ($kost) {
            $kost->limitedFacilities = $kost->facilities
                ->take(3) // Ambil 3 fasilitas pertama
                ->pluck('name') // Ambil hanya kolom 'name'
                ->implode(', '); // Gabungkan menjadi string dengan pemisah koma
        });

        $title = "Rekomendasi Kost Terbaik";
        $list = 'premium';
        return view('welcome', compact('kosts', 'title', 'list'));
    }
}
