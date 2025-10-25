<?php

namespace Mortezaa97\Catalogs\Policies;

use Mortezaa97\Catalogs\Models\Catalog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CatalogPolicy
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
    public function view(User $user, Catalog $catalog): bool
    {
        return $user->id === $catalog->created_by || $user->hasRole('admin');
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
    public function update(User $user, Catalog $catalog): bool
    {
        return $user->id === $catalog->created_by || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Catalog $catalog): bool
    {
        return $user->id === $catalog->created_by || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Catalog $catalog): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Catalog $catalog): bool
    {
        return $user->hasRole('admin');
    }
}
