<?php

namespace App\Http\Controllers;

use App\Models\DetalleHorarioMantenimiento;
use App\Models\HorarioMantenimiento;
use App\Models\Mantenimiento;
use Illuminate\Http\Request;

class DetalleHorarioMantenimientoController extends Controller
{
    public function index(Mantenimiento $mantenimiento, HorarioMantenimiento $horario, Request $request)
    {
        if ($request->ajax()) {
            $detalles = DetalleHorarioMantenimiento::where('horario_mantenimiento_id', $horario->id)->get();
            return response()->json(['data' => $detalles]);
        }
        return view('admin.detalle_horario.index', compact('mantenimiento', 'horario'));
    }

    public function create(Mantenimiento $mantenimiento, HorarioMantenimiento $horario)
    {
        return view('admin.detalle_horario.create', compact('mantenimiento', 'horario'));
    }

    public function store(Request $request, Mantenimiento $mantenimiento, HorarioMantenimiento $horario)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'fecha' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($mantenimiento) {
                    if ($value < $mantenimiento->fecha_inicio || $value > $mantenimiento->fecha_fin) {
                        $fail('La fecha debe estar dentro del rango del mantenimiento.');
                    }
                },
                function ($attribute, $value, $fail) use ($horario) {
                    $dias = [
                        'Domingo',
                        'Lunes',
                        'Martes',
                        'Miércoles',
                        'Jueves',
                        'Viernes',
                        'Sábado'
                    ];
                    $diaFecha = $dias[date('w', strtotime($value))];
                    if ($diaFecha !== $horario->dia_de_la_semana) {
                        $fail('La fecha debe ser un ' . $horario->dia_de_la_semana . '.');
                    }
                }
            ],
            'imagen' => 'nullable|image|max:2048',
        ]);

        $detalle = new DetalleHorarioMantenimiento();
        $detalle->horario_mantenimiento_id = $horario->id;
        $detalle->descripcion = $request->descripcion;
        $detalle->fecha = $request->fecha;

        if ($request->hasFile('imagen')) {
            $detalle->imagen = $request->file('imagen')->store('detalle_horario', 'public');
        }

        $detalle->save();


        if ($request->ajax()) {
            return response()->json(['message' => 'Detalle registrado correctamente']);
        }

        return redirect()->route('admin.mantenimientos.horarios.detalles.index', [$mantenimiento, $horario])
            ->with('success', 'Detalle registrado correctamente');
    }

    public function edit(Mantenimiento $mantenimiento, HorarioMantenimiento $horario, DetalleHorarioMantenimiento $detalle)
    {
        return view('admin.detalle_horario.edit', compact('mantenimiento', 'horario', 'detalle'));
    }

    public function update(Request $request, Mantenimiento $mantenimiento, HorarioMantenimiento $horario, DetalleHorarioMantenimiento $detalle)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'fecha' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($mantenimiento) {
                    if ($value < $mantenimiento->fecha_inicio || $value > $mantenimiento->fecha_fin) {
                        $fail('La fecha debe estar dentro del rango del mantenimiento.');
                    }
                },
                function ($attribute, $value, $fail) use ($horario) {
                    $dias = [
                        'Domingo',
                        'Lunes',
                        'Martes',
                        'Miércoles',
                        'Jueves',
                        'Viernes',
                        'Sábado'
                    ];
                    $diaFecha = $dias[date('w', strtotime($value))];
                    if ($diaFecha !== $horario->dia_de_la_semana) {
                        $fail('La fecha debe ser un ' . $horario->dia_de_la_semana . '.');
                    }
                }
            ],
            'imagen' => 'nullable|image|max:2048',
        ]);

        $detalle->descripcion = $request->descripcion;
        $detalle->fecha = $request->fecha;

        if ($request->hasFile('imagen')) {
            $detalle->imagen = $request->file('imagen')->store('detalle_horario', 'public');
        }

        $detalle->save();


        if ($request->ajax()) {
            return response()->json(['message' => 'Detalle actualizado correctamente']);
        }

        return redirect()->route('admin.mantenimientos.horarios.detalles.index', [$mantenimiento, $horario])
            ->with('success', 'Detalle actualizado correctamente');
    }

    public function destroy(Mantenimiento $mantenimiento, HorarioMantenimiento $horario, DetalleHorarioMantenimiento $detalle, Request $request)
    {

        if ($detalle->imagen) {
            \storage_path()::disk('public')->delete($detalle->imagen);
        }
        $detalle->delete();


        if ($request->ajax()) {
            return response()->json(['message' => 'Detalle eliminado correctamente']);
        }

        return redirect()->route('admin.mantenimientos.horarios.detalles.index', [$mantenimiento, $horario])
            ->with('success', 'Detalle eliminado correctamente');
    }
}
