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
        'type_id',
    ];

    public function model()
    {
        return $this->belongsTo(\App\Models\Brandmodel::class, 'model_id');
    }

    public function color()
    {
        return $this->belongsTo(\App\Models\Color::class, 'color_id');
    }

    public function brand()
    {
        return $this->belongsTo(\App\Models\Brand::class, 'brand_id');
    }

    public function type()
    {
        return $this->belongsTo(\App\Models\Vehicletype::class, 'type_id');
    }
}
