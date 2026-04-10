<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'company_id',
        'store_code',
        'store_name',
        'area'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function rates()
    {
        return $this->hasMany(DestinationRate::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
