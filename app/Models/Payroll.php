<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'company_id',
        'week_start',
        'week_end',
        'is_processed'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function assignments()
    {
        return $this->hasMany(TripAssignment::class);
    }

    public function ledgers()
    {
        return $this->hasMany(PayrollPersonLedger::class);
    }
}