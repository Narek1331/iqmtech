<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository
{
    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return User
     */
    public function findById(int $id): ?User
    {
        return User::find($id) ?? null;
    }
}
