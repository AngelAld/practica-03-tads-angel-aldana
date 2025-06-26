<?php

namespace App\Http\Controllers;

use App\Models\HorarioMantenimiento;
use App\Models\Mantenimiento;
use Illuminate\Http\Request;

class HorarioMantenimientoController extends Controller
{
    public function index(Mantenimiento $mantenimiento, Request $request)
    {
        if ($request->ajax()) {
            $horarios = HorarioMantenimiento::where('mantenimiento_id', $mantenimiento->id)
                ->with(['vehicle', 'employee'])
                ->get();
            return response()->json(['data' => $horarios]);
        }
        return view('admin.horarios.index', compact('mantenimiento'));
    }

    public function create(Mantenimiento $mantenimiento)
    {
        return view('admin.horarios.create', compact('mantenimiento'));
    }

    public function store(Request $request, Mantenimiento $mantenimiento)
    {
        $this->validate($request, [
            'dia_de_la_semana' => 'required|string',
            'vehicle_id' => 'required|exists:vehicles,id',
            'employee_id' => 'required|exists:employees,id',
            'tipo' => 'required|string|max:255',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);


        $existeSolapamiento = HorarioMantenimiento::where('mantenimiento_id', $mantenimiento->id)
            ->where('vehicle_id', $request->vehicle_id)
            ->where('dia_de_la_semana', $request->dia_de_la_semana)
            ->where(function ($q) use ($request) {
                $q->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                    ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('hora_inicio', '<=', $request->hora_inicio)
                            ->where('hora_fin', '>=', $request->hora_fin);
                    });
            })
            ->exists();

        if ($existeSolapamiento) {
            return response()->json(['message' => 'El horario se solapa con otro para este vehículo y día.'], 422);
        }

        HorarioMantenimiento::create([
            'mantenimiento_id' => $mantenimiento->id,
            'dia_de_la_semana' => $request->dia_de_la_semana,
            'vehicle_id' => $request->vehicle_id,
            'employee_id' => $request->employee_id,
            'tipo' => $request->tipo,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return response()->json(['message' => 'Horario creado correctamente']);
    }

    public function edit(Mantenimiento $mantenimiento, HorarioMantenimiento $horario)
    {
        return view('admin.horarios.edit', compact('mantenimiento', 'horario'));
    }

    public function update(Request $request, Mantenimiento $mantenimiento, HorarioMantenimiento $horario)
    {
        $this->validate($request, [
            'dia_de_la_semana' => 'required|string',
            'vehicle_id' => 'required|exists:vehicles,id',
            'employee_id' => 'required|exists:employees,id',
            'tipo' => 'required|string|max:255',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);


        $existeSolapamiento = HorarioMantenimiento::where('mantenimiento_id', $mantenimiento->id)
            ->where('vehicle_id', $request->vehicle_id)
            ->where('dia_de_la_semana', $request->dia_de_la_semana)
            ->where('id', '!=', $horario->id)
            ->where(function ($q) use ($request) {
                $q->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                    ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('hora_inicio', '<=', $request->hora_inicio)
                            ->where('hora_fin', '>=', $request->hora_fin);
                    });
            })
            ->exists();

        if ($existeSolapamiento) {
            return response()->json(['message' => 'El horario se solapa con otro para este vehículo y día.'], 422);
        }

        $horario->update([
            'dia_de_la_semana' => $request->dia_de_la_semana,
            'vehicle_id' => $request->vehicle_id,
            'employee_id' => $request->employee_id,
            'tipo' => $request->tipo,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return response()->json(['message' => 'Horario actualizado correctamente']);
    }

    public function destroy(Mantenimiento $mantenimiento, HorarioMantenimiento $horario)
    {
        if ($horario->detalles()->exists()) {
            return response()->json(['message' => 'No se puede eliminar el horario porque tiene actividades asociadas.'], 400);
        }
        $horario->delete();
        return response()->json(['message' => 'Horario eliminado correctamente']);
    }
}
