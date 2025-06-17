<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function index(Request $request)
    {
        // DataTables espera un array 'data' con los registros
        if ($request->ajax()) {
            $periods = Period::all();
            return response()->json(['data' => $periods]);
        }
        $periods = Period::all();
        return view('admin.periods.index', compact('periods'));
    }

    public function create()
    {
        // Devuelve el formulario de creación (puede ser un partial/modal)
        return view('admin.periods.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|boolean',
            ]);
            $period = Period::create($validated);
            return response()->json(['success' => true, 'message' => 'Periodo creado correctamente', 'period' => $period], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Datos inválidos', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al crear el periodo: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $period = Period::findOrFail($id);
        return view('admin.periods.edit', compact('period'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|boolean',
            ]);
            $period = Period::findOrFail($id);
            $period->update($validated);
            return response()->json(['success' => true, 'message' => 'Periodo actualizado correctamente', 'period' => $period]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Datos inválidos', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar el periodo: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $period = Period::findOrFail($id);
            $period->delete();
            return response()->json(['success' => true, 'message' => 'Periodo eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el periodo: ' . $e->getMessage()], 500);
        }
    }
}
