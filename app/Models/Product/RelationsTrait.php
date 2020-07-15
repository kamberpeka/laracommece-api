<?php

namespace App\Models\Product;

use App\Models\ProductAttribute\ProductAttribute;

trait RelationsTrait
{
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
