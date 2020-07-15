<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use AttributesTrait,
        RelationsTrait,
        ScopesTrait,
        SoftDeletes;

    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'alias',
        'first_name',
        'last_name',
        'company',
        'address1',
        'address2',
        'postcode',
        'city',
        'state',
        'country',
        'phone',
        'phone_mobile',
        'vat_number',
        'other',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
