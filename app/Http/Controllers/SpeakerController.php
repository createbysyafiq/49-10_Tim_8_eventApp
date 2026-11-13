<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Speaker::class);
        $speakers = Speaker::latest()->get();
        return view('speakers.index', compact('speakers'));
    }

    public function create()
    {
        $this->authorize('create', Speaker::class);
        return view('speakers.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Speaker::class);

        $request->validate([
            'nama'       => 'required|string|max:100',
            'email'      => 'required|email|max:100',
            'topik'      => 'required|string|max:200',
            'keahlian'   => 'nullable|string|max:100',
            'institusi'  => 'required|string|max:100',
            'portofolio' => 'nullable|string|max:255',
            'no_hp'      => 'required|string|max:20',
        ]);

        Speaker::create($request->all());

        return redirect()->route('speakers.index')
            ->with('success', 'Data Pembicara / Speaker berhasil ditambahkan!');
    }

    public function show(Speaker $speaker)
    {
        $this->authorize('view', $speaker);
        return view('speakers.show', compact('speaker'));
    }

    public function edit(Speaker $speaker)
    {
        $this->authorize('update', $speaker);
        return view('speakers.edit', compact('speaker'));
    }

    public function update(Request $request, Speaker $speaker)
    {
        $this->authorize('update', $speaker);

        $request->validate([
            'nama'       => 'required|string|max:100',
            'email'      => 'required|email|max:100',
            'topik'      => 'required|string|max:200',
            'keahlian'   => 'nullable|string|max:100',
            'institusi'  => 'required|string|max:100',
            'portofolio' => 'nullable|string|max:255',
            'no_hp'      => 'required|string|max:20',
        ]);

        $speaker->update($request->all());

        return redirect()->route('speakers.index')
            ->with('success', 'Data Pembicara berhasil diperbarui!');
    }

    public function destroy(Speaker $speaker)
    {
        $this->authorize('delete', $speaker);
        $speaker->delete();

        return redirect()->route('speakers.index')
            ->with('success', 'Data Pembicara berhasil dihapus!');
    }
}

