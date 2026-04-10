<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable = [
        'company_id',
        'trip_id',
        'client_name',
        'rate',
        'amount',
        'bank_name',
        'check_number',
        'check_release_date',
        'status'
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
