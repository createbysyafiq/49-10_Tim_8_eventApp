<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Peserta;
use App\Models\Speaker;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\EventPolicy;
use App\Policies\PesertaPolicy;
use App\Policies\SpeakerPolicy;
use App\Policies\TicketPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Ticket::class => TicketPolicy::class,
        Peserta::class => PesertaPolicy::class,
        Event::class => EventPolicy::class,
        Speaker::class => SpeakerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate 1: Mengelola akun user & hak akses sistem (khusus Admin)
        Gate::define('manage-users', function (User $user) {
            return $user->role === 'admin';
        });

        // Gate 2: Mengelola operasional workshop (khusus Admin)
        Gate::define('manage-all', function (User $user) {
            return $user->role === 'admin';
        });

        // Gate 3: Otorisasi khusus penghapusan data krusial (hanya Admin)
        Gate::define('delete-record', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
