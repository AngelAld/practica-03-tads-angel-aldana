<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioMantenimiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'mantenimiento_id',
        'dia_de_la_semana',
        'vehicle_id',
        'employee_id',
        'tipo',
        'hora_inicio',
        'hora_fin',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function mantenimiento()
    {
        return $this->belongsTo(Mantenimiento::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetalleHorarioMantenimiento::class);
    }
}
