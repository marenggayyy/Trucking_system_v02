<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'company_id',
        'truck_id',
        'destination_id',
        'trip_date',
        'internal_amount',
        'status',
        'dispatched_at',
        'dispatched_by',
        'completed_at',
        'completed_by',
        'remarks'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function assignments()
    {
        return $this->hasMany(TripAssignment::class);
    }

    public function billings()
    {
        return $this->hasMany(Billing::class);
    }
}