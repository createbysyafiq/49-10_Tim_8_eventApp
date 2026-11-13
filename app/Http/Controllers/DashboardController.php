<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Peserta;
use App\Models\Speaker;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'events'   => Event::count(),
            'speakers' => Speaker::count(),
            'tickets'  => Ticket::count(),
            'peserta'  => Peserta::count(),
        ];

        $user = Auth::user();

        // Riwayat tiket / pendaftaran milik peserta sendiri jika role = peserta
        $myRegistrations = [];
        if ($user && $user->isPeserta()) {
            $myRegistrations = Peserta::with('ticket')
                ->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                          ->orWhere('email', $user->email);
                })
                ->latest()
                ->take(3)
                ->get();
        }

        return view('dashboard', compact('stats', 'user', 'myRegistrations'));
    }
}
