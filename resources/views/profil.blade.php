@extends('layouts.app')

@section('title', 'Profil Mahasiswa')

@section('content')
<div class="max-w-2xl mx-auto py-6">
    <!-- Tombol Kembali (Sesuai Modul 3 Hal 21) -->
    <div class="mb-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded-full shadow-sm hover:bg-gray-50 transition">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Card Profil (Sesuai Modul 3 Hal 20-22) -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
        <!-- Header Profil dengan Gradient -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-center text-white">
            <!-- Inisial Nama (Sesuai Modul 3 Hal 21) -->
            <div class="w-24 h-24 rounded-full bg-white text-blue-700 text-4xl font-bold flex items-center justify-center mx-auto shadow-md mb-4">
                {{ substr($mahasiswa->nama ?? 'M', 0, 1) }}
            </div>
            <!-- Nama Mahasiswa (Sesuai Modul 3 Hal 21) -->
            <h2 class="text-2xl font-bold">{{ $mahasiswa->nama ?? 'Nama Mahasiswa' }}</h2>
            <!-- NIM Mahasiswa (Sesuai Modul 3 Hal 22) -->
            <p class="text-blue-100 text-sm mt-1">{{ $mahasiswa->nim ?? '102022xxxx' }}</p>
        </div>

        <!-- Detail Profil Mahasiswa -->
        <div class="p-6 space-y-4">
            <!-- Program Studi (Sesuai Modul 3 Hal 22) -->
            <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 border border-gray-100">
                <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xl flex-shrink-0">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Program Studi</span>
                    <h5 class="text-base font-semibold text-gray-800">{{ $mahasiswa->prodi ?? 'S1 Sistem Informasi' }}</h5>
                </div>
            </div>

            <!-- Email (Sesuai Modul 3 Hal 22) -->
            <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 border border-gray-100">
                <div class="w-12 h-12 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-xl flex-shrink-0">
                    <i class="bi bi-envelope-fill"></i>
                </div>
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Email Kampus</span>
                    <h5 class="text-base font-semibold text-gray-800">{{ $mahasiswa->email ?? 'mahasiswa@student.telkomuniversity.ac.id' }}</h5>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-4 text-center border-t border-gray-100 text-xs text-gray-400">
            Profil Praktikan Mata Kuliah Web Application Development
        </div>
    </div>
</div>
@endsection

