<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Ticket::class);
        $tickets = Ticket::latest()->get();
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Ticket::class);
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Ticket::class);

        $request->validate([
            'tipe_tiket' => 'required|string|max:255',
            'harga'      => 'required|numeric|min:0',
            'kuota'      => 'required|integer|min:1',
            'benefit'    => 'required|string',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only('tipe_tiket', 'harga', 'kuota', 'benefit');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('tickets', 'public');
        }

        Ticket::create($data);

        return redirect()->route('tickets.index')
            ->with('success', 'Tiket baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $this->authorize('update', $ticket);
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $request->validate([
            'tipe_tiket' => 'required|string|max:255',
            'harga'      => 'required|numeric|min:0',
            'kuota'      => 'required|integer|min:1',
            'benefit'    => 'required|string',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only('tipe_tiket', 'harga', 'kuota', 'benefit');

        if ($request->hasFile('gambar')) {
            if ($ticket->gambar) {
                Storage::disk('public')->delete($ticket->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('tickets', 'public');
        }

        $ticket->update($data);

        return redirect()->route('tickets.index')
            ->with('success', 'Data tiket berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);

        if ($ticket->gambar) {
            Storage::disk('public')->delete($ticket->gambar);
        }

        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Tiket berhasil dihapus!');
    }
}
