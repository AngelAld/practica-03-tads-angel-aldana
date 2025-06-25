<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicleimages extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicle_id',
        'image_path',
        'is_profile',
        'status'
    ];
}
