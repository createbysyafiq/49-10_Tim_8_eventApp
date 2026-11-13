@extends('layouts.app')

@section('title', 'Detail Tiket')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md my-8 border border-gray-100">
    <h2 class="text-xl font-bold mb-4">Detail Data Tiket</h2>

    <div class="space-y-3 text-sm">
        @if ($ticket->gambar)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $ticket->gambar) }}" alt="{{ $ticket->tipe_tiket }}" class="w-full max-h-60 object-cover rounded border">
            </div>
        @endif

        <div class="border-b pb-2">
            <span class="text-gray-500 block text-xs">Tipe Tiket:</span>
            <span class="font-bold text-gray-800 text-base">{{ $ticket->tipe_tiket }}</span>
        </div>

        <div class="border-b pb-2">
            <span class="text-gray-500 block text-xs">Harga:</span>
            <span class="font-bold text-green-700 text-base">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</span>
        </div>

        <div class="border-b pb-2">
            <span class="text-gray-500 block text-xs">Kuota:</span>
            <span class="font-semibold text-gray-800">{{ $ticket->kuota }}</span>
        </div>

        <div class="border-b pb-2">
            <span class="text-gray-500 block text-xs">Benefit:</span>
            <p class="text-gray-700 whitespace-pre-line mt-1">{{ $ticket->benefit }}</p>
        </div>
    </div>

    <div class="mt-6 flex space-x-2">
        <a href="{{ route('tickets.edit', $ticket) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-medium text-sm transition">
            Edit
        </a>
        <a href="{{ route('tickets.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded inline-block font-medium text-sm transition">
            Kembali
        </a>
    </div>
</div>
@endsection
