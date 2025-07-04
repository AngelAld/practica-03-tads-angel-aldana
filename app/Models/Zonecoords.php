<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zonecoords extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_id',
        'latitude',
        'longitude',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
