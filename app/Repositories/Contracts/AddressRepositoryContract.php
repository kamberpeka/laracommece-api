<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface AddressRepositoryContract extends BaseRepositoryContract
{
    /**
     * @param int $user_id
     * @return Builder|Model
     */
    public function ofUser(int $user_id);

    /**
     * @param int $user_id
     * @param int $id
     * @return Builder|Model
     */
    public function ofUserExcept(int $user_id, int $id);
}
