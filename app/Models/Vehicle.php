<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'plate',
        'year',
        'load_capacity',
        'description',
        'fuel_capacity',
        'ocuppants',
        'status',
        'model_id',
        'color_id',
        'brand_id',
    ];
}
