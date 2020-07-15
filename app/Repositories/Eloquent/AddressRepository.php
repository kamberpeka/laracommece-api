<?php

namespace App\Repositories\Eloquent;

use App\Models\Address\Address;
use App\Repositories\Contracts\AddressRepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AddressRepository extends BaseRepository implements AddressRepositoryContract
{
    protected function model()
    {
        return Address::class;
    }

    /**
     * @param int $user_id
     * @return Builder|Model
     */
    public function ofUser(int $user_id)
    {
        return $this->model->where('user_id', $user_id);
    }

    /**
     * @param int $user_id
     * @param int $id
     * @return Builder|Model
     */
    public function ofUserExcept(int $user_id, int $id)
    {
        return $this->model->where('user_id', $user_id)->where('id', '!=', $id);
    }
}
