<?php

namespace App\Policies;

use App\Models\User;

class CategoryPolicy
{
    public function before(User $user)
    {
        return $user->isAdmin();
    }
}
