<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Pengelolaan Event & Workshop
|--------------------------------------------------------------------------
|
| Rute dilengkapi dengan Middleware Authentication (auth), Account Status
| Check (active), dan Role-Based Access Control (role:admin,peserta).
|
*/

// ==========================================
// 1. GUEST ROUTES (Belum Login)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// ==========================================
// 2. AUTHENTICATED & ACTIVE ROUTES
// ==========================================
Route::middleware(['auth', 'active'])->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard & Profil
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

    // ----------------------------------------------------
    // Modul A: Master Event
    // ----------------------------------------------------
    // Read: Semua role yang login (Peserta, Admin)
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show')->whereNumber('event');

    // Create, Update & Delete: Khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });


    // ----------------------------------------------------
    // Modul B: Pembicara / Speaker
    // ----------------------------------------------------
    // Read: Semua role yang login (Peserta, Admin)
    Route::get('/speakers', [SpeakerController::class, 'index'])->name('speakers.index');
    Route::get('/speakers/{speaker}', [SpeakerController::class, 'show'])->name('speakers.show')->whereNumber('speaker');

    // Create, Update & Delete: Khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/speakers/create', [SpeakerController::class, 'create'])->name('speakers.create');
        Route::post('/speakers', [SpeakerController::class, 'store'])->name('speakers.store');
        Route::get('/speakers/{speaker}/edit', [SpeakerController::class, 'edit'])->name('speakers.edit');
        Route::put('/speakers/{speaker}', [SpeakerController::class, 'update'])->name('speakers.update');
        Route::delete('/speakers/{speaker}', [SpeakerController::class, 'destroy'])->name('speakers.destroy');
    });


    // ----------------------------------------------------
    // Modul C: Tiket & Kategori
    // ----------------------------------------------------
    // Read: Semua role yang login (Peserta, Admin)
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show')->whereNumber('ticket');

    // Create, Update & Delete: Khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
        Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
        Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    });

    // Alias lama /ticket
    Route::get('/ticket', function () {
        return redirect()->route('tickets.index');
    });


    // ----------------------------------------------------
    // Modul D: Peserta & Biodata
    // ----------------------------------------------------
    // Read & Register: Semua role yang login
    Route::get('/peserta', [PesertaController::class, 'index'])->name('peserta.index');
    Route::get('/peserta/create', [PesertaController::class, 'create'])->name('peserta.create');
    Route::post('/peserta', [PesertaController::class, 'store'])->name('peserta.store');
    Route::get('/peserta/{peserta}', [PesertaController::class, 'show'])->name('peserta.show');

    // Edit & Update: Divalidasi oleh PesertaPolicy (Owner atau Admin)
    Route::get('/peserta/{peserta}/edit', [PesertaController::class, 'edit'])->name('peserta.edit');
    Route::put('/peserta/{peserta}', [PesertaController::class, 'update'])->name('peserta.update');

    // Delete: Khusus Admin
    Route::delete('/peserta/{peserta}', [PesertaController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('peserta.destroy');

});
