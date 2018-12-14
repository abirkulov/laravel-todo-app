<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolesPolicy
{
    use HandlesAuthorization;

    public function manageRoles(User $user)
    {
        return $user->hasRole('Admin');
    }
}
