<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\RoomiePaymentMethod;
use App\Models\Sewa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SewaController extends Controller
{
    /**
     * Menampilkan daftar sewa milik tenant yang sedang login.
     */
    public function index(): View
    {
        $sewas = Sewa::where('tenant_id', Auth::id())
            ->with('kost')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('sewa.index', compact('sewas'));
    }

    /**
     * Menampilkan form untuk membuat pengajuan sewa baru.
     */
    public function create(Kost $kost): View
    {
        $durations = $kost->durations()->pluck('price', 'type')->toArray();
        $promoCodes = $kost->kostAdvertisements()->get(['promo_code', 'promo_type', 'promo_value']);

        return view('sewa.create', [
            'kost' => $kost,
            'durations' => $durations,
            'promoCodes' => $promoCodes,
        ]);
    }

    /**
     * Menyimpan pengajuan sewa baru.
     */
    public function store(Request $request, Kost $kost): RedirectResponse
    {
        $validated = $request->validate([
            'duration' => ['required', 'string', 'in:daily,weekly,monthly,3_monthly,6_monthly,yearly'],
            'price' => ['required', 'numeric', 'min:0'],
            'promo_code' => ['nullable', 'string'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
        ], [
            'duration.required' => 'Durasi sewa harus dipilih.',
            'price.required' => 'Harga harus diisi.',
            'start_date.required' => 'Tanggal mulai sewa harus diisi.',
            'start_date.after_or_equal' => 'Tanggal mulai sewa tidak boleh sebelum hari ini.',
        ]);

        Sewa::create([
            'tenant_id' => Auth::id(),
            'kost_id' => $kost->id,
            'duration' => $validated['duration'],
            'price' => $validated['price'],
            'promo_code' => $validated['promo_code'],
            'start_date' => $validated['start_date'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('sewa.create', ['kost' => $kost])
            ->with('show_alert', true)
            ->with('success', 'Pengajuan sewa berhasil dikirim! Menunggu persetujuan owner.');
    }

    /**
     * Menampilkan form untuk mengunggah bukti pembayaran.
     */
    public function showUploadForm(Sewa $sewa): View
    {
        // Pastikan pengajuan sewa sudah disetujui
        if ($sewa->status !== 'approved') {
            abort(403, 'Pengajuan sewa belum disetujui.');
        }

        // Pastikan bukti pembayaran belum diunggah
        if ($sewa->payment_proof) {
            abort(403, 'Bukti pembayaran sudah diunggah.');
        }

        $paymentMethods = RoomiePaymentMethod::all();

        return view('sewa.upload', compact('sewa', 'paymentMethods'));
    }

    /**
     * Menyimpan bukti pembayaran yang diunggah.
     */
    public function uploadPaymentProof(Sewa $sewa, Request $request): RedirectResponse
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Maksimal 2MB
        ]);

        $paymentProofPath = $request->file('payment_proof')->store('sewa-payment-proof', 'public');

        $sewa->update([
            'payment_proof' => $paymentProofPath,
            'status' => 'payment_verified', // Ubah status menunggu verifikasi pembayaran
        ]);

        return redirect()
            ->route('sewa.index')
            ->with('success', 'Bukti pembayaran berhasil diunggah! Menunggu verifikasi.');
    }
}
