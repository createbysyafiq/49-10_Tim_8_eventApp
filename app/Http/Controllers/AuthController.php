<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan formulir login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses otentikasi login pengguna.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Cek apakah akun ada dan statusnya aktif
        $user = User::where('email', $credentials['email'])->first();
        if ($user && ! $user->is_active) {
            return back()->withErrors([
                'email' => 'Akses ditolak: Akun Anda sedang dinonaktifkan oleh Administrator.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Login berhasil! Selamat datang, ' . Auth::user()->nama . ' (' . ucfirst(Auth::user()->role) . ').');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan formulir registrasi.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Proses pendaftaran pengguna baru tanpa field NIM dan Prodi.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'nullable|in:peserta,panitia,admin',
        ]);

        $user = User::create([
            'nama'      => $validated['nama'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'role'      => $validated['role'] ?? 'peserta',
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Registrasi berhasil! Akun Anda aktif sebagai ' . ucfirst($user->role) . '.');
    }

    /**
     * Logout pengguna dan hancurkan sesi.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil logout dari sistem.');
    }
}
