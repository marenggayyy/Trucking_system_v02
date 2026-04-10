<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllowanceConfig extends Model
{
    protected $fillable = [
        'min_amount',
        'max_amount',
        'allowance'
    ];
}
