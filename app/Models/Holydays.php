<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holydays extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'period_id',
        'status',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
