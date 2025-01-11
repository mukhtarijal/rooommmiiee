<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Kost;
use Illuminate\Support\Facades\Auth;
class FavoriteController extends Controller
{
    public function index()
    {
        return view('favorit'); // Pastikan file view 'favorit.blade.php' ada di resources/views
    }

    public function toggle(Kost $kost): JsonResponse
    {
        try {
            $tenant = Auth::user();

            // Cek apakah kost sudah difavoritkan oleh tenant
            $favorite = Favorite::where('tenant_id', $tenant->id)
                ->where('kost_id', $kost->id)
                ->first();

            $isFavorite = false;

            if ($favorite) {
                // Jika sudah difavoritkan, hapus dari favorit
                $favorite->delete();
            } else {
                // Jika belum difavoritkan, tambahkan ke favorit
                Favorite::create([
                    'tenant_id' => $tenant->id,
                    'kost_id' => $kost->id,
                ]);
                $isFavorite = true;
            }

            return response()->json([
                'success' => true,
                'isFavorite' => $isFavorite,
                'message' => $isFavorite ? 'Berhasil menambahkan ke favorit' : 'Berhasil menghapus dari favorit'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses favorit'
            ], 500);
        }
    }

}
