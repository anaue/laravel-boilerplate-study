<?php

namespace App\Policies;
use App\User;
use App\Collector;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserCollectorPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * Determine if the given collector can be created by the user.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function store(User $user, Collector $collector )
    {
        return $user->delegation()->count() == 0;
    }
}
