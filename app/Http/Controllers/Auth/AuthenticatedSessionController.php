<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Pastikan Auth::user() tidak null
        if (!Auth::check()) {
            return back()->withErrors([
                'email' => __('Terjadi kesalahan saat autentikasi.'),
            ]);
        }

        // Cek apakah pengguna memiliki role 'tenant'
        if (!Auth::user()->hasRole('tenant')) {
            Auth::logout(); // Logout pengguna
            return back()->withErrors([
                'email' => __('Anda tidak terdaftar sebagai pencari kost.'),
            ]);
        }

        // Tambahkan fitur "Ingat Saya"
        if ($request->boolean('remember')) {
            Auth::guard('web')->login(Auth::user(), true);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
