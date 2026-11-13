<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Event::class);
        $events = Event::latest()->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        $this->authorize('create', Event::class);
        return view('events.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        $request->validate([
            'judul_event'   => 'required|string|max:150',
            'deskripsi'     => 'required|string',
            'kategori'      => 'required|in:Teknologi,Bisnis',
            'silabus'       => 'required|string',
            'durasi_sesi'   => 'required|string|max:50',
            'tanggal_mulai' => 'nullable|date',
            'lokasi'        => 'nullable|string|max:100',
        ]);

        Event::create($request->all());

        return redirect()->route('events.index')
            ->with('success', 'Master Event berhasil ditambahkan!');
    }

    public function show(Event $event)
    {
        $this->authorize('view', $event);
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $request->validate([
            'judul_event'   => 'required|string|max:150',
            'deskripsi'     => 'required|string',
            'kategori'      => 'required|in:Teknologi,Bisnis',
            'silabus'       => 'required|string',
            'durasi_sesi'   => 'required|string|max:50',
            'tanggal_mulai' => 'nullable|date',
            'lokasi'        => 'nullable|string|max:100',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')
            ->with('success', 'Data Master Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Data Event berhasil dihapus!');
    }
}

