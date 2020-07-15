<?php

namespace App\Repositories\Eloquent;

use App\Models\User\User;
use App\Repositories\Contracts\UserRepositoryContract;

class UserRepository extends BaseRepository implements UserRepositoryContract
{
    protected function model()
    {
        return User::class;
    }
}
