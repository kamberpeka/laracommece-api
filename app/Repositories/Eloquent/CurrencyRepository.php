<?php

namespace App\Repositories\Eloquent;

use App\Models\Currency\Currency;
use App\Repositories\Contracts\CurrencyRepositoryContract;

class CurrencyRepository extends BaseRepository implements CurrencyRepositoryContract
{
    protected function model()
    {
        return Currency::class;
    }
}
