<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the CMS login view.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle an authentication attempt for the CMS.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Nama pengguna atau email wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $login = $credentials['login'];
        $password = $credentials['password'];
        $remember = $request->boolean('remember');

        // Check against both name and email fields for seamless login
        $authenticated = Auth::attempt(['name' => $login, 'password' => $password], $remember)
            || Auth::attempt(['email' => $login, 'password' => $password], $remember);

        if ($authenticated) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang kembali di CMS Dashboard Drainusantara!');
        }

        return back()
            ->withInput($request->only('login', 'remember'))
            ->withErrors([
                'login' => 'Nama pengguna atau kata sandi tidak cocok dengan data kami.',
            ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('info', 'Anda telah berhasil keluar dari sesi CMS.');
    }
}
