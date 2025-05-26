<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Bts;
use Illuminate\Auth\Access\HandlesAuthorization;

class BtsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_bts');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Bts $bts): bool
    {
        return $user->can('view_bts');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_bts');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Bts $bts): bool
    {
        return $user->can('update_bts');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Bts $bts): bool
    {
        return $user->can('delete_bts');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_bts');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Bts $bts): bool
    {
        return $user->can('force_delete_bts');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_bts');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Bts $bts): bool
    {
        return $user->can('restore_bts');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_bts');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Bts $bts): bool
    {
        return $user->can('replicate_bts');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_bts');
    }
}
