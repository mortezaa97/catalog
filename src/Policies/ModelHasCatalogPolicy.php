<?php

namespace Mortezaa97\Catalogs\Policies;

use Mortezaa97\Catalogs\Models\ModelHasCatalog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ModelHasCatalogPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ModelHasCatalog $modelHasCatalog): bool
    {
        return $user->id === $modelHasCatalog->created_by || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ModelHasCatalog $modelHasCatalog): bool
    {
        return $user->id === $modelHasCatalog->created_by || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ModelHasCatalog $modelHasCatalog): bool
    {
        return $user->id === $modelHasCatalog->created_by || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ModelHasCatalog $modelHasCatalog): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ModelHasCatalog $modelHasCatalog): bool
    {
        return $user->hasRole('admin');
    }
}
