<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'load_requirement',
        'district_id',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function zone_coordinates()
    {
        return $this->hasMany(Zonecoords::class);
    }

    public function updateCoordinates(array $coords)
    {
        DB::transaction(function () use ($coords) {
            $this->zone_coordinates()->delete();
            foreach ($coords as $coord) {
                $this->zone_coordinates()->create([
                    'latitude' => $coord['lat'],
                    'longitude' => $coord['lng'],
                ]);
            }
        });
    }
}
