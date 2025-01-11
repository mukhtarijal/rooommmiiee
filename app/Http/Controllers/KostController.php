<?php

namespace App\Http\Controllers;

use App\Models\Kost;

class KostController extends Controller
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
            ->latest() // Urutkan dari yang terbaru
            ->paginate(15); // Paginasi, tampilkan 15 kost per halaman

        // Modifikasi data yang sudah dipaginasi
        $kosts->getCollection()->transform(function ($kost) {
            $kost->limitedFacilities = $kost->facilities
                ->take(3) // Ambil 3 fasilitas pertama
                ->pluck('name') // Ambil hanya kolom 'name'
                ->implode(', '); // Gabungkan menjadi string dengan pemisah koma

            return $kost;
        });

        // Tampilkan view daftar kost dengan data kost
        return view('kost.index', compact('kosts'));
    }

    public function show($slug)
    {
        // Ambil data kost berdasarkan slug
        $kost = Kost::with([
            'owner:id,name,phone', // Ambil name dan phone dari owner
            'city:id,name', // Ambil name dari city
            'rules:id,rule,icon', // Ambil rule dan icon dari rules
            'facilities:id,name,icon', // Ambil name dan icon dari facilities
            'durations:type,price,kost_id', // Ambil type dan price dari durations
            'photos:type,photo,kost_id', // Ambil type dan photo dari photos
            'reviews:rating,review,kost_id,tenant_id', // Ambil rating dan ulasan dari reviews
            'reviews.tenant:id,name', // Ambil nama user yang memberikan ulasan
            'favorites:kost_id,tenant_id' // Ambil data favorites untuk menandai jika kost favorit
        ])->where('slug', $slug)->firstOrFail();

        // Hitung rata-rata rating dari reviews
        $averageRating = $kost->reviews->avg('rating');

        // Tandai jika kost favorit oleh user yang sedang login (jika ada)
        $isFavorite = false;
        if (auth()->check()) {
            $isFavorite = $kost->favorites->contains('tenant_id', auth()->id());
        }

        // Tampilkan view detail kost dengan data kost
        return view('kost.detail', compact('kost', 'averageRating', 'isFavorite'));
    }

    public function premium()
    {
        // Ambil data kost premium dengan relasi yang diperlukan
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
            ->where('is_premium', 1) // Hanya ambil kost premium
            ->latest() // Urutkan dari yang terbaru
            ->paginate(15); // Paginasi, tampilkan 15 kost per halaman

        // Modifikasi data yang sudah dipaginasi
        $kosts->getCollection()->transform(function ($kost) {
            $kost->limitedFacilities = $kost->facilities
                ->take(3) // Ambil 3 fasilitas pertama
                ->pluck('name') // Ambil hanya kolom 'name'
                ->implode(', '); // Gabungkan menjadi string dengan pemisah koma

            return $kost;
        });

        // Tampilkan view daftar kost premium dengan data kost
        return view('kost.premium', compact('kosts'));
    }

    public function sameCity()
    {
        $user = auth()->user();

        // Ambil data kost dengan relasi yang diperlukan
        $kosts = Kost::with([
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
            ->latest() // Urutkan dari yang terbaru
            ->paginate(15); // Paginasi, tampilkan 15 kost per halaman

        // Modifikasi data yang sudah dipaginasi
        $kosts->getCollection()->transform(function ($kost) {
            $kost->limitedFacilities = $kost->facilities
                ->take(3) // Ambil 3 fasilitas pertama
                ->pluck('name') // Ambil hanya kolom 'name'
                ->implode(', '); // Gabungkan menjadi string dengan pemisah koma

            return $kost;
        });

        // Tampilkan view daftar kost dengan data kost
        return view('kost.same-city', compact('kosts'));
    }
}
