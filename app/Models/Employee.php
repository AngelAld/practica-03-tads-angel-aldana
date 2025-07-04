<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'names',
        'lastnames',
        'dni',
        'birthday',
        'license',
        'address',
        'email',
        'photo',
        'phone',
        'status',
    ];

    public function functions()
    {
        return $this->belongsToMany(
            Employeefunction::class,
            'employeefunctiondetails',
            'employee_id',
            'employeefunction_id'
        )->withTimestamps()->withPivot('status');
    }
}
