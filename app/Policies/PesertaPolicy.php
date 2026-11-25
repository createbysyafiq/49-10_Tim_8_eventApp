<?php

namespace App\Policies;

use App\Models\Peserta;
use App\Models\User;

class PesertaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     * Ownership check: Admin can view all; Peserta can only view their own.
     */
    public function view(User $user, Peserta $peserta): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $peserta->user_id || $user->email === $peserta->email;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * Ownership check: Admin can edit all; Peserta can only edit their own.
     */
    public function update(User $user, Peserta $peserta): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $peserta->user_id || $user->email === $peserta->email;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Peserta $peserta): bool
    {
        return $user->role === 'admin';
    }
}
