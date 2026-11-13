@extends('layouts.app')

@section('title', 'Daftar Pembicara / Speaker')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 my-4">

    <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Modul Pembicara &amp; Narasumber</h2>
            <p class="text-xs text-gray-500 mt-1">Pengelolaan data speaker, bidang keahlian, topik presentasi, dan portofolio.</p>
        </div>
        @can('create', App\Models\Speaker::class)
            <a href="{{ route('speakers.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2 rounded-md shadow-sm transition">
                + Tambah Pembicara Baru
            </a>
        @endcan
    </div>

    <!-- Tabel Daftar Pembicara -->
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200 text-sm">
                <thead>
                    <tr class="bg-indigo-600 text-white font-semibold">
                        <th class="p-3 border border-indigo-700 text-center w-12">No</th>
                        <th class="p-3 border border-indigo-700 text-left">Nama &amp; Kontak</th>
                        <th class="p-3 border border-indigo-700 text-left">Topik Workshop</th>
                        <th class="p-3 border border-indigo-700 text-left">Institusi &amp; Keahlian</th>
                        <th class="p-3 border border-indigo-700 text-center">Portofolio</th>
                        <th class="p-3 border border-indigo-700 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($speakers as $index => $speaker)
                    <tr class="hover:bg-slate-50 border-b border-gray-200">
                        <td class="p-3 text-center">{{ $index + 1 }}</td>
                        <td class="p-3">
                            <strong class="text-gray-800">{{ $speaker->nama }}</strong>
                            <div class="text-xs text-gray-500 mt-0.5">
                                {{ $speaker->email }} &bull; {{ $speaker->no_hp }}
                            </div>
                        </td>
                        <td class="p-3 text-gray-700 font-medium">
                            {{ $speaker->topik }}
                        </td>
                        <td class="p-3">
                            <span class="text-gray-800 font-semibold">{{ $speaker->institusi }}</span>
                            <div class="text-xs text-gray-500">
                                Bidang: {{ $speaker->keahlian ?? '-' }}
                            </div>
                        </td>
                        <td class="p-3 text-center">
                            @if($speaker->portofolio)
                                <a href="{{ $speaker->portofolio }}" target="_blank" class="text-xs text-indigo-600 hover:underline font-semibold">
                                    Tautan Web &rarr;
                                </a>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="p-3 text-center space-x-2 whitespace-nowrap">
                            @can('update', $speaker)
                                <a href="{{ route('speakers.edit', $speaker) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-xs">
                                    Edit
                                </a>
                            @endcan

                            @can('delete', $speaker)
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('speakers.destroy', $speaker) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus narasumber ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-xs bg-transparent border-0 p-0 cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            @endcan

                            @cannot('update', $speaker)
                                <span class="text-xs text-gray-400 italic">Hanya Lihat</span>
                            @endcannot
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-400 italic">Belum ada data pembicara.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

