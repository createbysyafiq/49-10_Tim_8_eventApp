@extends('layouts.app')

@section('title', 'Edit Data Pembicara')

@section('content')
<div class="max-w-2xl mx-auto my-6">
    <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Edit Data Pembicara</h2>
            <a href="{{ route('speakers.index') }}" class="text-xs text-gray-600 hover:text-blue-600">&larr; Kembali</a>
        </div>

        <form action="{{ route('speakers.update', $speaker) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="nama" class="block font-semibold text-xs text-gray-700 mb-1">Nama Lengkap &amp; Gelar:</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $speaker->nama) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block font-semibold text-xs text-gray-700 mb-1">Alamat Email:</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $speaker->email) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="no_hp" class="block font-semibold text-xs text-gray-700 mb-1">Nomor Kontak / WhatsApp:</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $speaker->no_hp) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label for="topik" class="block font-semibold text-xs text-gray-700 mb-1">Topik Presentasi Workshop:</label>
                <input type="text" name="topik" id="topik" value="{{ old('topik', $speaker->topik) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="institusi" class="block font-semibold text-xs text-gray-700 mb-1">Institusi / Perusahaan Asal:</label>
                    <input type="text" name="institusi" id="institusi" value="{{ old('institusi', $speaker->institusi) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="keahlian" class="block font-semibold text-xs text-gray-700 mb-1">Bidang Keahlian:</label>
                    <input type="text" name="keahlian" id="keahlian" value="{{ old('keahlian', $speaker->keahlian) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label for="portofolio" class="block font-semibold text-xs text-gray-700 mb-1">Tautan Portofolio / LinkedIn:</label>
                <input type="url" name="portofolio" id="portofolio" value="{{ old('portofolio', $speaker->portofolio) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="pt-4 text-center">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-md shadow text-sm transition">
                    Perbarui Data Pembicara
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

