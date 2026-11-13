@extends('layouts.app')

@section('title', 'Form Pengelolaan Tiket')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md my-8 border border-gray-100">
    <h2 class="text-xl font-bold mb-4">Tambah Data Tiket</h2>

    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold text-sm mb-1">Tipe Tiket:</label>
            <select name="tipe_tiket" required class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">-- Pilih Tipe --</option>
                <option value="Early Bird" {{ old('tipe_tiket') == 'Early Bird' ? 'selected' : '' }}>Early Bird</option>
                <option value="Regular" {{ old('tipe_tiket') == 'Regular' ? 'selected' : '' }}>Regular</option>
                <option value="VIP" {{ old('tipe_tiket') == 'VIP' ? 'selected' : '' }}>VIP</option>
            </select>
            @error('tipe_tiket')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold text-sm mb-1">Harga (Rp):</label>
            <input type="number" name="harga" value="{{ old('harga') }}" placeholder="Contoh: 100000" required 
                   class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
            @error('harga')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold text-sm mb-1">Kuota:</label>
            <input type="number" name="kuota" value="{{ old('kuota') }}" placeholder="Contoh: 50" required 
                   class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
            @error('kuota')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold text-sm mb-1">Benefit:</label>
            <textarea name="benefit" rows="3" placeholder="Sertifikat, Snack, Modul Workshop..." required 
                      class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">{{ old('benefit') }}</textarea>
            @error('benefit')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label class="block font-semibold text-sm mb-1">Foto Tiket (Opsional):</label>
            <input type="file" name="gambar" accept="image/*" class="w-full border border-gray-300 p-1.5 rounded text-sm bg-white">
            @error('gambar')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-2">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-medium text-sm transition">
                Simpan Tiket
            </button>
            <a href="{{ route('tickets.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded inline-block font-medium text-sm transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
