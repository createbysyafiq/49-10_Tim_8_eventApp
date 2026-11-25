@extends('layouts.app')

@section('title', 'Daftar Akun Baru - Sistem Event & Workshop')

@section('content')
<div class="max-w-md mx-auto my-8">
    <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Registrasi Akun</h2>
            <p class="text-xs text-gray-500 mt-1">Daftarkan akun Anda untuk mengakses sistem</p>
        </div>

        <form action="{{ route('register.process') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="nama" class="block font-semibold text-xs text-gray-700 mb-1">Nama Lengkap:</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required autofocus
                       placeholder="Contoh: Budi Santoso"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block font-semibold text-xs text-gray-700 mb-1">Email Aktif:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       placeholder="nama@email.com"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Role / Hak Akses (Opsi untuk kemudahan testing) -->
            <div>
                <label for="role" class="block font-semibold text-xs text-gray-700 mb-1">Daftar Sebagai Peran (Role):</label>
                <select name="role" id="role" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="peserta" {{ old('role') == 'peserta' ? 'selected' : '' }}>Peserta Event (Default)</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
                <p class="text-[11px] text-gray-400 mt-0.5">Pilih peran sesuai skenario pengujian role access control.</p>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block font-semibold text-xs text-gray-700 mb-1">Kata Sandi (Min 6 Karakter):</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block font-semibold text-xs text-gray-700 mb-1">Konfirmasi Kata Sandi:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Tombol Register -->
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md shadow text-sm transition">
                Daftar &amp; Buat Akun
            </button>
        </form>

        <div class="mt-6 pt-4 border-t border-gray-100 text-center text-xs text-gray-500">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection
