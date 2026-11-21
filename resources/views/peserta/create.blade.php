@extends('layouts.app')

@section('title', 'Pendaftaran Peserta Event')

@section('content')
<div class="max-w-2xl mx-auto my-6">
    <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Form Pendaftaran Peserta Event</h2>
            <a href="{{ route('peserta.index') }}" class="text-xs text-gray-600 hover:text-blue-600">&larr; Kembali</a>
        </div>

        <form action="{{ route('peserta.store') }}" method="POST" class="space-y-4">
            @csrf
<!-- FORM CREATE PESERTA -->
            <!-- Pilih Tiket -->
            <div>
                <label for="id_tiket" class="block font-semibold text-xs text-gray-700 mb-1">Pilih Kategori Tiket Workshop:</label>
                <select name="id_tiket" id="id_tiket" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">-- Pilih Tiket --</option>
                    @foreach($tickets as $ticket)
                        <option value="{{ $ticket->id }}" {{ (old('id_tiket', request('id_tiket')) == $ticket->id) ? 'selected' : '' }}>
                            {{ $ticket->tipe_tiket }} - Rp {{ number_format($ticket->harga, 0, ',', '.') }} (Sisa Kuota: {{ $ticket->kuota }})
                        </option>
                    @endforeach
                </select>
                @error('id_tiket')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label for="nama_lengkap" class="block font-semibold text-xs text-gray-700 mb-1">Nama Lengkap Peserta:</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" 
                       value="{{ old('nama_lengkap', Auth::user()->nama ?? '') }}" required
                       placeholder="Contoh: Budi Santoso"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                @error('nama_lengkap')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Email Aktif -->
                <div>
                    <label for="email" class="block font-semibold text-xs text-gray-700 mb-1">Email Aktif:</label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email', Auth::user()->email ?? '') }}" required
                           placeholder="nama@email.com"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No WhatsApp -->
                <div>
                    <label for="no_hp" class="block font-semibold text-xs text-gray-700 mb-1">Nomor WhatsApp / HP:</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" required
                           placeholder="Contoh: 081234567890"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    @error('no_hp')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Asal Institusi / Kampus -->
            <div>
                <label for="institusi" class="block font-semibold text-xs text-gray-700 mb-1">Asal Instansi / Universitas:</label>
                <input type="text" name="institusi" id="institusi" 
                       value="{{ old('institusi', Auth::user()->prodi ?? '') }}" required
                       placeholder="Contoh: Telkom University Bandung"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                @error('institusi')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Pembayaran (Bisa diatur Admin / Panitia) -->
            @if(in_array(Auth::user()->role ?? '', ['admin', 'panitia']))
            <div>
                <label for="status_pembayaran" class="block font-semibold text-xs text-gray-700 mb-1">Status Pembayaran (Otoritas Pengelola):</label>
                <select name="status_pembayaran" id="status_pembayaran" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="Lunas" {{ old('status_pembayaran') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="Menunggu" {{ old('status_pembayaran') == 'Menunggu' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="Batal" {{ old('status_pembayaran') == 'Batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
            @endif

            <div class="pt-4 text-center">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-8 rounded-md shadow text-sm transition">
                    Kirim Pendaftaran Peserta
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

