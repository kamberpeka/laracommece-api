<?php

namespace App\Repositories\Eloquent;

use App\Models\Product\Product;
use App\Repositories\Contracts\ProductRepositoryContract;

class ProductRepository extends BaseRepository implements ProductRepositoryContract
{
    protected function model()
    {
        return Product::class;
    }
}
