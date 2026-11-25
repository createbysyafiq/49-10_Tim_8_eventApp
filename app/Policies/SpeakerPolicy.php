<?php

namespace App\Policies;

use App\Models\Speaker;
use App\Models\User;

class SpeakerPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Speaker $speaker): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Speaker $speaker): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Speaker $speaker): bool
    {
        return $user->role === 'admin';
    }
}
