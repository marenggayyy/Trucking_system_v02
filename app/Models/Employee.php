<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'email',
        'profile_photo',
        'default_role',
        'availability_status',
        'employment_status'
    ];

    // 🔗 MANY TO MANY (companies)
    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    // 🔗 TRIP ASSIGNMENTS
    public function assignments()
    {
        return $this->hasMany(TripAssignment::class);
    }

    // 🔗 CASH ADVANCES
    public function cashAdvances()
    {
        return $this->hasMany(CashAdvance::class);
    }

    // 🔗 PAYROLL
    public function payrollLedgers()
    {
        return $this->hasMany(PayrollPersonLedger::class);
    }
}