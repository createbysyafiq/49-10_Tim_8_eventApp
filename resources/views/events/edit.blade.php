@extends('layouts.app')

@section('title', 'Edit Data Event')

@section('content')
<div class="max-w-2xl mx-auto my-6">
    <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Edit Data Event</h2>
            <a href="{{ route('events.index') }}" class="text-xs text-gray-600 hover:text-blue-600">&larr; Kembali</a>
        </div>

        <form action="{{ route('events.update', $event) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="judul_event" class="block font-semibold text-xs text-gray-700 mb-1">Judul Event / Workshop:</label>
                <input type="text" name="judul_event" id="judul_event" value="{{ old('judul_event', $event->judul_event) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="kategori" class="block font-semibold text-xs text-gray-700 mb-1">Kategori:</label>
                    <select name="kategori" id="kategori" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Teknologi" {{ old('kategori', $event->kategori) == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                        <option value="Bisnis" {{ old('kategori', $event->kategori) == 'Bisnis' ? 'selected' : '' }}>Bisnis</option>
                    </select>
                </div>

                <div>
                    <label for="durasi_sesi" class="block font-semibold text-xs text-gray-700 mb-1">Durasi Sesi:</label>
                    <input type="text" name="durasi_sesi" id="durasi_sesi" value="{{ old('durasi_sesi', $event->durasi_sesi) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label for="deskripsi" class="block font-semibold text-xs text-gray-700 mb-1">Deskripsi Event:</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('deskripsi', $event->deskripsi) }}</textarea>
            </div>

            <div>
                <label for="silabus" class="block font-semibold text-xs text-gray-700 mb-1">Silabus Materi:</label>
                <textarea name="silabus" id="silabus" rows="3" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('silabus', $event->silabus) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="tanggal_mulai" class="block font-semibold text-xs text-gray-700 mb-1">Tanggal Pelaksanaan:</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" 
                           value="{{ old('tanggal_mulai', $event->tanggal_mulai ? $event->tanggal_mulai->format('Y-m-d') : '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="lokasi" class="block font-semibold text-xs text-gray-700 mb-1">Lokasi Kegiatan:</label>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $event->lokasi) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="pt-4 text-center">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md shadow text-sm transition">
                    Perbarui Data Event
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

