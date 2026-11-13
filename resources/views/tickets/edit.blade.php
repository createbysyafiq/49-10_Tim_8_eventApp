@extends('layouts.app')

@section('title', 'Edit Tiket - Modul C')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md my-8 border border-gray-100">
    <h2 class="text-xl font-bold mb-4">Edit Data Tiket</h2>

    <form action="{{ route('tickets.update', $ticket) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold text-sm mb-1">Tipe Tiket:</label>
            <select name="tipe_tiket" required class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="Early Bird" {{ old('tipe_tiket', $ticket->tipe_tiket) == 'Early Bird' ? 'selected' : '' }}>Early Bird</option>
                <option value="Regular" {{ old('tipe_tiket', $ticket->tipe_tiket) == 'Regular' ? 'selected' : '' }}>Regular</option>
                <option value="VIP" {{ old('tipe_tiket', $ticket->tipe_tiket) == 'VIP' ? 'selected' : '' }}>VIP</option>
            </select>
            @error('tipe_tiket')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold text-sm mb-1">Harga (Rp):</label>
            <input type="number" name="harga" value="{{ old('harga', $ticket->harga) }}" required 
                   class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
            @error('harga')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold text-sm mb-1">Kuota:</label>
            <input type="number" name="kuota" value="{{ old('kuota', $ticket->kuota) }}" required 
                   class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
            @error('kuota')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold text-sm mb-1">Benefit:</label>
            <textarea name="benefit" rows="3" required 
                      class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">{{ old('benefit', $ticket->benefit) }}</textarea>
            @error('benefit')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label class="block font-semibold text-sm mb-1">Foto Tiket (Opsional):</label>
            @if ($ticket->gambar)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $ticket->gambar) }}" alt="Foto Tiket" class="w-32 h-20 object-cover rounded border">
                </div>
            @endif
            <input type="file" name="gambar" accept="image/*" class="w-full border border-gray-300 p-1.5 rounded text-sm bg-white">
            <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti gambar.</p>
            @error('gambar')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-medium text-sm transition">
                Simpan Perubahan
            </button>
            <a href="{{ route('tickets.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded inline-block font-medium text-sm transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
