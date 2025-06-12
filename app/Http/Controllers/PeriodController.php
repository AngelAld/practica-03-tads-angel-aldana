<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function index(Request $request)
    {
        $periods = Period::all();
        // Si la petición es AJAX, retornar JSON
        if ($request->ajax()) {
            return response()->json(['data' => $periods]);
        }
        // Para la vista
        return view('admin.periods.index', compact('periods'));
    }

    public function create()
    {
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

    // public function show($id)
    // {
    //     try {
    //         $period = Period::findOrFail($id);
    //         return response()->json(['success' => true, 'period' => $period]);
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false, 'message' => 'Periodo no encontrado'], 404);
    //     }
    // }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|boolean',
            ]);
            $period = Period::findOrFail($id);
            $period->update($validated);
            return response()->json(['success' => true, 'message' => 'Periodo actualizado correctamente', 'data' => $period]);
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
