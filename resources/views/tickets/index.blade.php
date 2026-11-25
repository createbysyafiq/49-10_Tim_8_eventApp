@extends('layouts.app')

@section('title', 'Form Pemesanan Tiket & Kategori')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 my-4">

    <!-- Card 1: Form Pengelolaan Tiket (Hanya Tampil Bagi Admin) -->
    @can('create', App\Models\Ticket::class)
    <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Form Pengelolaan Tiket &amp; Kategori</h2>
                <p class="text-xs text-gray-500 mt-0.5">Tambah kategori tiket baru untuk peserta event</p>
            </div>
            <span class="bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded border border-blue-200">
                Akses: Admin
            </span>
        </div>
        
        <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <!-- Tipe Tiket -->
            <div>
                <label for="tipe_tiket" class="block font-semibold text-sm text-gray-700 mb-1">Tipe Tiket:</label>
                <select name="tipe_tiket" id="tipe_tiket" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="">-- Pilih Tipe --</option>
                    <option value="Early Bird" {{ old('tipe_tiket') == 'Early Bird' ? 'selected' : '' }}>Early Bird (Diskon Khusus Awal)</option>
                    <option value="Regular" {{ old('tipe_tiket') == 'Regular' ? 'selected' : '' }}>Regular (Tiket Standar)</option>
                    <option value="VIP" {{ old('tipe_tiket') == 'VIP' ? 'selected' : '' }}>VIP (Akses Prioritas)</option>
                </select>
                @error('tipe_tiket')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga Tiket -->
            <div>
                <label for="harga" class="block font-semibold text-sm text-gray-700 mb-1">Harga (Rp):</label>
                <input type="number" name="harga" id="harga" min="0" placeholder="Contoh: 100000" value="{{ old('harga') }}" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('harga')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kuota Tiket -->
            <div>
                <label for="kuota" class="block font-semibold text-sm text-gray-700 mb-1">Kuota Kursi:</label>
                <input type="number" name="kuota" id="kuota" min="1" placeholder="Contoh: 50" value="{{ old('kuota') }}" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('kuota')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Benefit / Fasilitas -->
            <div>
                <label for="benefit" class="block font-semibold text-sm text-gray-700 mb-1">Benefit / Fasilitas:</label>
                <textarea name="benefit" id="benefit" rows="3" placeholder="Sertifikat, Snack, Modul Workshop..." required 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('benefit') }}</textarea>
                @error('benefit')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Gambar (Fitur Modul 3) -->
            <div>
                <label for="gambar" class="block font-semibold text-sm text-gray-700 mb-1">Foto / Poster Tiket (Opsional):</label>
                <input type="file" name="gambar" id="gambar" accept="image/*" 
                       class="w-full px-3 py-1.5 border border-gray-300 rounded-md focus:outline-none text-sm bg-white">
                @error('gambar')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Simpan Tiket -->
            <div class="text-center pt-2">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-8 rounded-md shadow transition duration-200">
                    Simpan Tiket
                </button>
            </div>

        </form>
    </div>
    @else
    <!-- Informasi Pembatasan Akses untuk Peserta -->
    <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl text-xs text-blue-800 flex justify-between items-center">
        <div>
            <strong>Perhatian (Role Peserta):</strong> Anda sedang melihat katalog tiket workshop. Fitur tambah, edit, dan hapus tiket dibatasi hanya untuk Administrator.
        </div>
        <a href="{{ route('peserta.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3 py-1.5 rounded shadow text-xs whitespace-nowrap">
            Daftar Tiket Sekarang &rarr;
        </a>
    </div>
    @endcan

    <!-- Card 2: Tabel Data Tiket -->
    <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
        <div class="flex justify-between items-center mb-5">
            <h3 class="text-lg font-bold text-gray-800">Daftar Tiket &amp; Kategori Event</h3>
            <span class="text-xs text-gray-500">Total: {{ $tickets->count() }} Data</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200 text-sm">
                <thead>
                    <tr class="bg-blue-600 text-white font-semibold">
                        <th class="p-3 border border-blue-700 text-center w-12">No</th>
                        <th class="p-3 border border-blue-700 text-center">Tipe Tiket</th>
                        <th class="p-3 border border-blue-700 text-center">Harga</th>
                        <th class="p-3 border border-blue-700 text-center">Kuota</th>
                        <th class="p-3 border border-blue-700 text-center">Benefit</th>
                        <th class="p-3 border border-blue-700 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $index => $ticket)
                    <tr class="hover:bg-slate-50 border-b border-gray-200">
                        <td class="p-3 text-center">{{ $index + 1 }}</td>
                        <td class="p-3 font-semibold text-gray-800 text-center">
                            {{ $ticket->tipe_tiket }}
                            @if ($ticket->gambar)
                                <div class="mt-1">
                                    <a href="{{ asset('storage/' . $ticket->gambar) }}" target="_blank" class="text-xs text-blue-500 underline">Lihat Foto</a>
                                </div>
                            @endif
                        </td>
                        <td class="p-3 text-center">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</td>
                        <td class="p-3 text-center">{{ $ticket->kuota }}</td>
                        <td class="p-3 text-left">{!! nl2br(e($ticket->benefit)) !!}</td>
                        <td class="p-3 text-center space-x-2 whitespace-nowrap">
                            @can('update', $ticket)
                                <a href="{{ route('tickets.edit', $ticket) }}" class="text-blue-600 hover:text-blue-800 font-medium text-xs">Edit</a>
                            @endcan

                            @can('delete', $ticket)
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus tiket ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-xs bg-transparent border-0 p-0 cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            @endcan

                            @if(Auth::user()->isPeserta())
                                <a href="{{ route('peserta.create', ['id_tiket' => $ticket->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-2.5 py-1 rounded inline-block font-medium">
                                    Pesan Tiket
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-400 italic">Belum ada data tiket.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
