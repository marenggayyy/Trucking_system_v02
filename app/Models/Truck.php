<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $fillable = [
        'company_id',
        'plate_number',
        'truck_type',
        'status',
        'availability_status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
