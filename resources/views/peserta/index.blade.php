@extends('layouts.app')

@section('title', 'Daftar Peserta & Biodata')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 my-4">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-xl shadow-sm border border-gray-200 gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Modul Peserta &amp; Biodata</h2>
            <p class="text-xs text-gray-500 mt-1">
                @if(Auth::user()->isPeserta())
                    Menampilkan riwayat dan status pendaftaran tiket workshop milik akun Anda.
                @else
                    Direktori seluruh peserta workshop terdaftar (Akses Pengelola: {{ ucfirst(Auth::user()->role) }}).
                @endif
            </p>
        </div>
        <a href="{{ route('peserta.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2 rounded-md shadow-sm transition whitespace-nowrap">
            + Pendaftaran Peserta Baru
        </a>
    </div>

    @if(Auth::user()->isPeserta())
    <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-xl text-xs text-emerald-800">
        <strong>Pemberitahuan Hak Akses (ABAC - Attribute-Based Access Control):</strong> Sesuai kebijakan keamanan, akun dengan role <strong>Peserta</strong> hanya dapat melihat dan mengelola data pendaftarannya sendiri. Data peserta lain tidak dapat diakses.
    </div>
    @endif

    <!-- Tabel Data Peserta -->
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200 text-sm">
                <thead>
                    <tr class="bg-emerald-600 text-white font-semibold">
                        <th class="p-3 border border-emerald-700 text-center w-12">No</th>
                        <th class="p-3 border border-emerald-700 text-left">Nama Peserta &amp; Kontak</th>
                        <th class="p-3 border border-emerald-700 text-left">Asal Institusi / Kampus</th>
                        <th class="p-3 border border-emerald-700 text-center">Kategori Tiket</th>
                        <th class="p-3 border border-emerald-700 text-center">Status</th>
                        <th class="p-3 border border-emerald-700 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesertas as $index => $peserta)
                    <tr class="hover:bg-slate-50 border-b border-gray-200">
                        <td class="p-3 text-center">{{ $index + 1 }}</td>
                        <td class="p-3">
                            <strong class="text-gray-800">{{ $peserta->nama_lengkap }}</strong>
                            <div class="text-xs text-gray-500 mt-0.5">
                                {{ $peserta->email }} &bull; {{ $peserta->no_hp }}
                            </div>
                        </td>
                        <td class="p-3 text-gray-700">
                            {{ $peserta->institusi }}
                        </td>
                        <td class="p-3 text-center">
                            @if($peserta->ticket)
                                <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-gray-300">
                                    {{ $peserta->ticket->tipe_tiket }}
                                </span>
                                <div class="text-[11px] text-gray-500 mt-0.5">
                                    Rp {{ number_format($peserta->ticket->harga, 0, ',', '.') }}
                                </div>
                            @else
                                <span class="text-xs text-gray-400 italic">Tiket tidak ditemukan</span>
                            @endif
                        </td>
                        <td class="p-3 text-center">
                            @if($peserta->status_pembayaran === 'Lunas')
                                <span class="bg-green-100 text-green-800 text-[11px] font-bold px-2 py-0.5 rounded">LUNAS</span>
                            @elseif($peserta->status_pembayaran === 'Menunggu')
                                <span class="bg-amber-100 text-amber-800 text-[11px] font-bold px-2 py-0.5 rounded">MENUNGGU</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-[11px] font-bold px-2 py-0.5 rounded">BATAL</span>
                            @endif
                        </td>
                        <td class="p-3 text-center space-x-2 whitespace-nowrap">
                            @can('update', $peserta)
                                <a href="{{ route('peserta.edit', $peserta) }}" class="text-emerald-700 hover:text-emerald-900 font-medium text-xs">
                                    Edit
                                </a>
                            @endcan

                            @can('delete', $peserta)
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('peserta.destroy', $peserta) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data peserta ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-xs bg-transparent border-0 p-0 cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            @endcan

                            @cannot('update', $peserta)
                                <span class="text-xs text-gray-400 italic">Hanya Lihat</span>
                            @endcannot
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-400 italic">
                            @if(Auth::user()->isPeserta())
                                Anda belum memiliki pendaftaran tiket workshop. Silakan klik tombol "+ Pendaftaran Peserta Baru" di atas.
                            @else
                                Belum ada data peserta terdaftar.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

