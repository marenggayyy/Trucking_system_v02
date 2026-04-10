<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollPersonLedger extends Model
{
    protected $fillable = [
        'payroll_id',
        'employee_id',
        'total_earnings',
        'allowance',
        'bonus',
        'sss',
        'pagibig',
        'philhealth',
        'cash_advance',
        'net_pay',
        'payment_status'
    ];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}