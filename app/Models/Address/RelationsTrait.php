<?php

namespace App\Models\Address;

use App\Models\User\User;

trait RelationsTrait
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
