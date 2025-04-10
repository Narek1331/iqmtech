<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Data;
use App\Models\User;

class DataPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Data');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Data $data): bool
    {
        return $user->checkPermissionTo('view Data');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Data');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Data $data): bool
    {
        return $user->checkPermissionTo('update Data');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Data $data): bool
    {
        return $user->checkPermissionTo('delete Data');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Data');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Data $data): bool
    {
        return $user->checkPermissionTo('restore Data');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Data');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Data $data): bool
    {
        return $user->checkPermissionTo('replicate Data');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Data');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Data $data): bool
    {
        return $user->checkPermissionTo('force-delete Data');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Data');
    }
}
