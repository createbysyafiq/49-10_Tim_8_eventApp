@extends('layouts.app')

@section('title', '403 Forbidden - Akses Ditolak')

@section('content')
<div class="max-w-xl mx-auto my-12">
    <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100 text-center">
        <!-- Badge Status Kode -->
        <span class="inline-block bg-red-100 text-red-700 font-bold px-3 py-1 rounded-full text-xs mb-3 border border-red-200">
            HTTP 403 FORBIDDEN
        </span>

        <h2 class="text-2xl font-bold text-gray-800 mb-2">Akses Ditolak (Unauthorized)</h2>
        
        <p class="text-sm text-gray-600 mb-6 leading-relaxed">
            {{ $exception->getMessage() ?: 'Maaf, akun Anda tidak memiliki izin otorisasi yang cukup untuk mengakses URL atau melakukan aksi pada data ini.' }}
        </p>

        @auth
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-xs text-left mb-6 space-y-1">
            <p><strong>Nama Akun:</strong> {{ Auth::user()->nama }}</p>
            <p><strong>Role Anda:</strong> <span class="uppercase font-bold text-blue-700">{{ Auth::user()->role }}</span></p>
            <p class="text-gray-500 pt-1">
                Fitur ini dilindungi oleh <strong>EnsureUserHasRole Middleware</strong> dan <strong>Laravel Policy</strong>.
            </p>
        </div>
        @endauth

        <div class="flex justify-center gap-3">
            <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-5 rounded-md text-xs shadow transition">
                &larr; Kembali ke Dashboard
            </a>
            <a href="javascript:history.back()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-md text-xs transition">
                Halaman Sebelumnya
            </a>
        </div>
    </div>
</div>
@endsection

