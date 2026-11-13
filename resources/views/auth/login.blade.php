@extends('layouts.app')

@section('title', 'Login - Sistem Event & Workshop')

@section('content')
<div class="max-w-md mx-auto my-8">
    <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Login Sistem</h2>
            <p class="text-xs text-gray-500 mt-1">Masuk untuk mengakses modul dan dashboard event</p>
        </div>

        <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email Input -->
            <div>
                <label for="email" class="block font-semibold text-xs text-gray-700 mb-1">Alamat Email:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       placeholder="nama@email.com"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block font-semibold text-xs text-gray-700 mb-1">Kata Sandi (Password):</label>
                <input type="password" name="password" id="password" required
                       placeholder="Masukkan kata sandi"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs text-gray-600">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span>Ingat saya</span>
                </label>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md shadow text-sm transition">
                Masuk ke Sistem
            </button>
        </form>

        <div class="mt-6 pt-4 border-t border-gray-100 text-center text-xs text-gray-500">
            Belum memiliki akun? 
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">Daftar sekarang</a>
        </div>
    </div>
</div>
@endsection

