<?php

namespace App\Models\User;

use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Hash;

trait AttributesTrait
{
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function isAdmin()
    {
        return $this->role == RoleEnum::ADMIN;
    }

    public function isCustomer()
    {
        return $this->role == RoleEnum::CUSTOMER;
    }

    public function isGuest()
    {
        return $this->guest == 1;
    }
}
