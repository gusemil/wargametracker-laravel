<?php

namespace App\Policies;

use App\Models\PlayedMatch;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

class PlayedMatchPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PlayedMatch $playedMatch): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return Auth::user()->is_admin;   
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(): bool
    {
        return Auth::user()->is_admin;   
    }

    public function edit(): bool
    {
        return Auth::user()->is_admin;   
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(): bool
    {
        return Auth::user()->is_admin;   
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PlayedMatch $playedMatch): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PlayedMatch $playedMatch): bool
    {
        return false;
    }
}
