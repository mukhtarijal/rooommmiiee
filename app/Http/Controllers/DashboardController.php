<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = auth()->user();
        $userName = $user->name;

        // Ambil data kost premium
        $premiumKosts = Kost::with([
            'durations' => function ($query) {
                $query->where('type', 'monthly'); // Ambil harga per bulan
            },
            'photos' => function ($query) {
                $query->where('type', 'kost')->take(1); // Ambil 1 foto dengan tipe kost
            },
            'facilities', // Ambil relasi fasilitas
        ])
            ->where('status', 'approved') // Hanya ambil kost yang statusnya approved
            ->where('is_premium', 1) // Hanya ambil kost premium
            ->latest()
            ->get();

        // Ambil data kost biasa (non-premium)
        $allKosts = Kost::with([
            'durations' => function ($query) {
                $query->where('type', 'monthly'); // Ambil harga per bulan
            },
            'photos' => function ($query) {
                $query->where('type', 'kost')->take(1); // Ambil 1 foto dengan tipe kost
            },
            'facilities', // Ambil relasi fasilitas
        ])
            ->where('status', 'approved') // Hanya ambil kost yang statusnya approved
            ->latest()
            ->paginate(12); // Paginasi, tampilkan 12 kost per halaman

        // Ambil daftar kost yang memiliki city_id yang sama dengan city_id user
        $sameCityKosts = Kost::with([
            'durations' => function ($query) {
                $query->where('type', 'monthly'); // Ambil harga per bulan
            },
            'photos' => function ($query) {
                $query->where('type', 'kost')->take(1); // Ambil 1 foto dengan tipe kost
            },
            'facilities', // Ambil relasi fasilitas
            'city', // Ambil data kota
        ])
            ->where('status', 'approved') // Hanya ambil kost yang statusnya approved
            ->where('city_id', $user->city_id) // Hanya ambil kost yang city_id-nya sama dengan city_id user
            ->latest()
            ->get();

        // Tambahkan properti limitedFacilities untuk setiap kost premium
        $premiumKosts->each(function ($kost) {
            $kost->limitedFacilities = $kost->facilities
                ->take(3) // Ambil 3 fasilitas pertama
                ->pluck('name') // Ambil hanya kolom 'name'
                ->implode(', '); // Gabungkan menjadi string dengan pemisah koma
        });

        // Kirim data ke view
        return view('dashboard', [
            'premiumKosts' => $premiumKosts,
            'allKosts' => $allKosts,
            'sameCityKosts' => $sameCityKosts,
            'premiumTitle' => 'Rekomendasi Kost Terbaik',
            'allTitle' => 'Semua Kost Untuk Kamu',
            'sameCityTitle' => 'Kost di Kotamu',
            'premiumList' => 'premium',
            'allList' => 'all',
            'sameCityList' => 'same-city',
            'userName' => $userName,
        ]);
    }

    public function search(Request $request)
    {
        // Ambil query pencarian
        $query = $request->input('query');

        // Lakukan pencarian berdasarkan nama kost
        $searchResults = Kost::with([
            'durations' => function ($query) {
                $query->where('type', 'monthly'); // Ambil harga per bulan
            },
            'photos' => function ($query) {
                $query->where('type', 'kost')->take(1); // Ambil 1 foto dengan tipe kost
            },
            'facilities', // Ambil relasi fasilitas
            'city', // Ambil data kota
            'owner', // Ambil data pemilik kost
        ])
            ->where('status', 'approved') // Hanya ambil kost yang statusnya approved
            ->where('name', 'like', "%{$query}%") // Cari berdasarkan nama kost
            ->latest()
            ->get();

        // Kirim hasil pencarian ke view
        return view('dashboard', [
            'searchResults' => $searchResults,
            'searchQuery' => $query,
        ]);
    }
}
