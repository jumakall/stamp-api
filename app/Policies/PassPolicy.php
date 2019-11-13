<?php

namespace App\Policies;

use App\User;
use App\Pass;

class PassPolicy
{
    public function store(User $user)
    {
        return $user->is_vendor;
    }
 
    public function update(User $user, Pass $pass)
    {
        return $user->id === $pass->user_id;
    }

    public function destroy(User $user, Pass $pass)
    {
        return $user->id === $pass->user_id;
    }

    public function stamp(User $user, Pass $pass)
    {
        return $user->id === $pass->user_id;
    }
}