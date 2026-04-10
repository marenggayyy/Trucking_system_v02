<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function trucks()
    {
        return $this->hasMany(Truck::class);
    }

    public function destinations()
    {
        return $this->hasMany(Destination::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}
