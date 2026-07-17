<?php

namespace App\Policies;

use App\Models\Dataset;
use App\Models\User;

class DatasetPolicy
{
    /**
     * Admins bypass every check below.
     */
    public function before(User $user, string $ability): ?bool
    {
        return $user->is_admin ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Dataset $dataset): bool
    {
        return $dataset->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Dataset $dataset): bool
    {
        return $dataset->user_id === $user->id;
    }

    public function delete(User $user, Dataset $dataset): bool
    {
        return $dataset->user_id === $user->id;
    }
}
