@extends('layouts.app')

@section('title', 'Dashboard Utama - Sistem Pengelolaan Event & Workshop')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 my-4">

    <!-- Card 1: User Greeting & Identity Banner -->
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Selamat Datang, {{ $user->nama ?? 'Pengguna' }}!
            </h2>
            <p class="text-gray-500 text-xs mt-1">
                Sistem Pengelolaan Event &amp; Workshop &bull; Studi Kasus 08 PAW Kelompok 8
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs text-gray-500 font-medium">Peran / Hak Akses:</span>
            @if(($user->role ?? '') === 'admin')
                <span class="bg-rose-100 text-rose-800 text-xs font-bold px-3 py-1 rounded-full border border-rose-200">
                    ADMINISTRATOR
                </span>
            @else
                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full border border-emerald-200">
                    PESERTA WORKSHOP
                </span>
            @endif
        </div>
    </div>

    <!-- Card 2: Statistik Ringkas 4 Modul -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 text-center">
            <span class="text-xs text-gray-500 uppercase font-semibold">Master Event</span>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $stats['events'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 text-center">
            <span class="text-xs text-gray-500 uppercase font-semibold">Pembicara</span>
            <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $stats['speakers'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 text-center">
            <span class="text-xs text-gray-500 uppercase font-semibold">Kategori Tiket</span>
            <p class="text-2xl font-bold text-amber-600 mt-1">{{ $stats['tickets'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 text-center">
            <span class="text-xs text-gray-500 uppercase font-semibold">Total Peserta</span>
            <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $stats['peserta'] }}</p>
        </div>
    </div>

    <!-- Card 3: Navigasi CRUD ke 4 Modul Sistem (Team Repository Merge) -->
    <div>
        <h3 class="text-base font-bold text-gray-800 mb-3">Modul Pengelolaan Sistem (4 Modul Anggota):</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            
            <!-- Modul A: Master Event -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-[11px] font-bold bg-blue-50 text-blue-700 px-2 py-0.5 rounded border border-blue-200">Individu A</span>
                        <span class="text-xs text-gray-400 font-medium">CRUD Event</span>
                    </div>
                    <h4 class="font-bold text-gray-800 text-base">Modul Master Event</h4>
                    <p class="text-xs text-gray-600 mt-1 mb-4">
                        Pengelolaan judul event, deskripsi, kategori (Teknologi/Bisnis), silabus, dan durasi sesi.
                    </p>
                </div>
                <div class="flex items-center gap-2 pt-2 border-t border-gray-100">
                    <a href="{{ route('events.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded shadow-sm">
                        Buka Event &rarr;
                    </a>
                    @if(($user->role ?? '') === 'admin')
                        <a href="{{ route('events.create') }}" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 text-xs font-medium px-3 py-1.5 rounded">
                            + Tambah Event
                        </a>
                    @endif
                </div>
            </div>

            <!-- Modul B: Pembicara / Speaker -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-[11px] font-bold bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded border border-indigo-200">Individu B</span>
                        <span class="text-xs text-gray-400 font-medium">CRUD Speaker</span>
                    </div>
                    <h4 class="font-bold text-gray-800 text-base">Modul Pembicara (Speaker)</h4>
                    <p class="text-xs text-gray-600 mt-1 mb-4">
                        Pengelolaan data narasumber/speaker, profil keahlian, institusi, topik, dan kontak.
                    </p>
                </div>
                <div class="flex items-center gap-2 pt-2 border-t border-gray-100">
                    <a href="{{ route('speakers.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-3 py-1.5 rounded shadow-sm">
                        Buka Pembicara &rarr;
                    </a>
                    @if(($user->role ?? '') === 'admin')
                        <a href="{{ route('speakers.create') }}" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 text-xs font-medium px-3 py-1.5 rounded">
                            + Tambah Speaker
                        </a>
                    @endif
                </div>
            </div>

            <!-- Modul C: Tiket & Kategori -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-[11px] font-bold bg-amber-50 text-amber-700 px-2 py-0.5 rounded border border-amber-200">Individu C</span>
                        <span class="text-xs text-gray-400 font-medium">CRUD Tiket</span>
                    </div>
                    <h4 class="font-bold text-gray-800 text-base">Modul Tiket &amp; Kategori</h4>
                    <p class="text-xs text-gray-600 mt-1 mb-4">
                        Pengelolaan tipe tiket (Early Bird, VIP, Regular), harga, kuota, benefit, dan upload poster.
                    </p>
                </div>
                <div class="flex items-center gap-2 pt-2 border-t border-gray-100">
                    <a href="{{ route('tickets.index') }}" class="bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold px-3 py-1.5 rounded shadow-sm">
                        Buka Modul Tiket &rarr;
                    </a>
                    @if(($user->role ?? '') === 'admin')
                        <a href="{{ route('tickets.create') }}" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 text-xs font-medium px-3 py-1.5 rounded">
                            + Tambah Tiket
                        </a>
                    @endif
                </div>
            </div>

            <!-- Modul D: Peserta & Biodata -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-[11px] font-bold bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded border border-emerald-200">Individu D</span>
                        <span class="text-xs text-gray-400 font-medium">CRUD Peserta</span>
                    </div>
                    <h4 class="font-bold text-gray-800 text-base">Modul Peserta &amp; Biodata</h4>
                    <p class="text-xs text-gray-600 mt-1 mb-4">
                        Pendaftaran peserta, pengelolaan profil, instansi kampus, tiket yang dipilih, dan status kehadiran.
                    </p>
                </div>
                <div class="flex items-center gap-2 pt-2 border-t border-gray-100">
                    <a href="{{ route('peserta.index') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-1.5 rounded shadow-sm">
                        Buka Peserta &rarr;
                    </a>
                    <a href="{{ route('peserta.create') }}" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 text-xs font-medium px-3 py-1.5 rounded">
                        + Daftar Peserta
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
