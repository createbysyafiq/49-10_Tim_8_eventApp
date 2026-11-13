@extends('layouts.app')

@section('title', 'Master Event & Workshop')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 my-4">

    <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Modul Master Event &amp; Workshop</h2>
            <p class="text-xs text-gray-500 mt-1">Pengelolaan data agenda, kategori, silabus, dan jadwal pelaksanaan.</p>
        </div>
        @can('create', App\Models\Event::class)
            <a href="{{ route('events.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-md shadow-sm transition">
                + Tambah Event Baru
            </a>
        @endcan
    </div>

    <!-- Daftar Card Event -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse($events as $event)
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start gap-2 mb-2">
                    <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full {{ $event->kategori === 'Teknologi' ? 'bg-cyan-100 text-cyan-800 border border-cyan-200' : 'bg-purple-100 text-purple-800 border border-purple-200' }}">
                        {{ $event->kategori }}
                    </span>
                    <span class="text-xs text-gray-500 font-medium">
                        Durasi: {{ $event->durasi_sesi }}
                    </span>
                </div>

                <h3 class="text-base font-bold text-gray-800 mb-2">{{ $event->judul_event }}</h3>
                <p class="text-xs text-gray-600 mb-3 leading-relaxed">{{ $event->deskripsi }}</p>

                <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 text-xs mb-3 space-y-1">
                    <p><strong>Silabus Materi:</strong></p>
                    <div class="text-gray-600 whitespace-pre-line pl-2">{{ $event->silabus }}</div>
                </div>

                @if($event->lokasi || $event->tanggal_mulai)
                <div class="text-[11px] text-gray-500 space-y-0.5">
                    @if($event->tanggal_mulai)
                        <p>&bull; Tanggal: {{ $event->tanggal_mulai->format('d M Y') }}</p>
                    @endif
                    @if($event->lokasi)
                        <p>&bull; Lokasi: {{ $event->lokasi }}</p>
                    @endif
                </div>
                @endif
            </div>

            <!-- Tombol Aksi Sesuai Role Access Control -->
            <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end items-center gap-2">
                @can('update', $event)
                    <a href="{{ route('events.edit', $event) }}" class="text-xs text-blue-600 hover:text-blue-800 font-semibold px-2 py-1 rounded hover:bg-blue-50">
                        Edit
                    </a>
                @endcan

                @can('delete', $event)
                    <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-semibold px-2 py-1 rounded hover:bg-red-50">
                            Hapus
                        </button>
                    </form>
                @endcan
            </div>
        </div>
        @empty
        <div class="col-span-2 bg-white p-8 text-center text-gray-400 rounded-xl border border-gray-200">
            Belum ada data event terdaftar.
        </div>
        @endforelse
    </div>

</div>
@endsection

