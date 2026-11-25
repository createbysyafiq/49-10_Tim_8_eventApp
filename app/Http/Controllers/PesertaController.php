<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesertaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // RBAC & ABAC: Peserta hanya melihat data pendaftaran miliknya sendiri.
        // Admin dapat melihat seluruh pendaftar.
        if ($user->isPeserta()) {
            $pesertas = Peserta::with('ticket')
                ->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                          ->orWhere('email', $user->email);
                })
                ->latest()
                ->get();
        } else {
            $pesertas = Peserta::with('ticket')->latest()->get();
        }

        return view('peserta.index', compact('pesertas'));
    }

    public function create()
    {
        $tickets = Ticket::all();
        return view('peserta.create', compact('tickets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tiket'          => 'required|exists:tickets,id',
            'nama_lengkap'      => 'required|string|max:100',
            'email'             => 'required|email|max:100',
            'no_hp'             => 'required|string|max:20',
            'institusi'         => 'required|string|max:100',
            'status_pembayaran' => 'nullable|in:Menunggu,Lunas,Batal',
        ]);

        $data = $request->all();
        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        }

        Peserta::create($data);

        return redirect()->route('peserta.index')
            ->with('success', 'Pendaftaran peserta berhasil disimpan!');
    }

    public function show(Peserta $peserta)
    {
        $this->authorize('view', $peserta);
        return view('peserta.show', compact('peserta'));
    }

    public function edit(Peserta $peserta)
    {
        $this->authorize('update', $peserta);
        $tickets = Ticket::all();
        return view('peserta.edit', compact('peserta', 'tickets'));
    }

    public function update(Request $request, Peserta $peserta)
    {
        $this->authorize('update', $peserta);

        $request->validate([
            'id_tiket'          => 'required|exists:tickets,id',
            'nama_lengkap'      => 'required|string|max:100',
            'email'             => 'required|email|max:100',
            'no_hp'             => 'required|string|max:20',
            'institusi'         => 'required|string|max:100',
            'status_pembayaran' => 'nullable|in:Menunggu,Lunas,Batal',
        ]);

        $peserta->update($request->all());

        return redirect()->route('peserta.index')
            ->with('success', 'Data peserta berhasil diperbarui!');
    }

    public function destroy(Peserta $peserta)
    {
        $this->authorize('delete', $peserta);
        $peserta->delete();

        return redirect()->route('peserta.index')
            ->with('success', 'Data peserta berhasil dihapus!');
    }
}

