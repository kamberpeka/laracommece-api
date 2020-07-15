<?php

namespace App\Models\Address;

trait AttributesTrait
{
    /**
     * ToDo Check if this address has any orders
     * @return bool
     */
    public function hasOrders()
    {
        return false;
    }
}
