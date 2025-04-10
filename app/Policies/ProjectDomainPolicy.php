<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\ProjectDomain;
use App\Models\User;

class ProjectDomainPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any ProjectDomain');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProjectDomain $projectdomain): bool
    {
        return $user->checkPermissionTo('view ProjectDomain');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create ProjectDomain');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProjectDomain $projectdomain): bool
    {
        return $user->checkPermissionTo('update ProjectDomain');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProjectDomain $projectdomain): bool
    {
        return $user->checkPermissionTo('delete ProjectDomain');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any ProjectDomain');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProjectDomain $projectdomain): bool
    {
        return $user->checkPermissionTo('restore ProjectDomain');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any ProjectDomain');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, ProjectDomain $projectdomain): bool
    {
        return $user->checkPermissionTo('replicate ProjectDomain');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder ProjectDomain');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProjectDomain $projectdomain): bool
    {
        return $user->checkPermissionTo('force-delete ProjectDomain');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any ProjectDomain');
    }
}
