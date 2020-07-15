<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Address\Address;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Address $address
     * @return mixed
     */
    public function view(User $user, Address $address)
    {
        return (
            $user->role === RoleEnum::ADMIN || $user->id ===$address->user_id
        );
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Address $address
     * @return mixed
     */
    public function update(User $user, Address $address)
    {
        return (
            $user->role === RoleEnum::ADMIN || $user->id ===$address->user_id
        );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Address $address
     * @return mixed
     */
    public function delete(User $user, Address $address)
    {
        return (
            $user->role === RoleEnum::ADMIN || $user->id ===$address->user_id
        );
    }
}
