<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripAssignment extends Model
{
    protected $fillable = [
        'trip_id',
        'employee_id',
        'role',
        'rate_percentage',
        'earning',
        'is_paid',
        'payroll_id'
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
