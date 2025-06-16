<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
