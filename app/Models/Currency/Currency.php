<?php

namespace App\Models\Currency;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'symbol',
        'iso_code',
        'numeric_iso_code',
        'conversion_rate',
        'active',
    ];
}
