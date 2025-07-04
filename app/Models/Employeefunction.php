<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employeefunction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function employees()
    {
        return $this->belongsToMany(
            Employee::class,
            'employeefunctiondetails',
            'employeefunction_id',
            'employee_id'
        )->withTimestamps()->withPivot('status');
    }
}
