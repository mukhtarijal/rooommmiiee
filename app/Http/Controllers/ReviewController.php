<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kost_id' => 'required|exists:kosts,id',
            'sewa_id' => 'required|exists:sewas,id',
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|max:1000',
        ]);

        // Cek apakah user sudah pernah memberikan review untuk kost ini
        $existingReview = Review::where('tenant_id', Auth::id())
            ->where('kost_id', $request->kost_id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk kost ini.');
        }

        Review::create([
            'tenant_id' => Auth::id(),
            'kost_id' => $request->kost_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->back()->with('success', 'Review berhasil dikirim!');
    }
}
