<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $mantenimientos = Mantenimiento::orderBy('fecha_inicio')->get();
            return response()->json(['data' => $mantenimientos]);
        }
        return view('admin.mantenimientos.index');
    }

    public function create()
    {
        return view('admin.mantenimientos.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        if (Mantenimiento::where(function ($q) use ($request) {
            $q->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin])
                ->orWhereBetween('fecha_fin', [$request->fecha_inicio, $request->fecha_fin])
                ->orWhere(function ($q2) use ($request) {
                    $q2->where('fecha_inicio', '<=', $request->fecha_inicio)
                        ->where('fecha_fin', '>=', $request->fecha_fin);
                });
        })->exists()) {
            return response()->json(['message' => 'Las fechas se solapan con otro mantenimiento.'], 422);
        }

        Mantenimiento::create($request->all());
        return response()->json(['message' => 'Mantenimiento creado correctamente']);
    }

    public function edit(Mantenimiento $mantenimiento)
    {
        return view('admin.mantenimientos.edit', compact('mantenimiento'));
    }

    public function update(Request $request, Mantenimiento $mantenimiento)
    {
        $this->validate($request, [
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        if (Mantenimiento::where('id', '!=', $mantenimiento->id)
            ->where(function ($q) use ($request) {
                $q->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin])
                    ->orWhereBetween('fecha_fin', [$request->fecha_inicio, $request->fecha_fin])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('fecha_inicio', '<=', $request->fecha_inicio)
                            ->where('fecha_fin', '>=', $request->fecha_fin);
                    });
            })->exists()
        ) {
            return response()->json(['message' => 'Las fechas se solapan con otro mantenimiento.'], 422);
        }

        $mantenimiento->update($request->all());
        return response()->json(['message' => 'Mantenimiento actualizado correctamente']);
    }

    public function destroy(Mantenimiento $mantenimiento)
    {
        if ($mantenimiento->horarios()->exists()) {
            return response()->json(['message' => 'No se puede eliminar el mantenimiento porque tiene horarios asociados.'], 400);
        }
        $mantenimiento->delete();
        return response()->json(['message' => 'Mantenimiento eliminado correctamente']);
    }
}
