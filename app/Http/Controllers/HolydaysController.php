<?php

namespace App\Http\Controllers;

use App\Models\Holydays;
use App\Models\Period;
use Illuminate\Http\Request;

class HolydaysController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $holidays = Holydays::with('period')->get();
            return response()->json(['data' => $holidays]);
        }
        return view('admin.holidays.index');
    }

    public function create()
    {
        $periods = Period::pluck('name', 'id');
        return view('admin.holidays.create', compact('periods'));
    }

    public function store(Request $request)
    {
        try {
            $request->merge([
                'name' => trim($request->input('name')),
                'description' => $request->has('description') ? trim($request->input('description')) : null,
            ]);
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'date' => 'required|date',
                'period_id' => 'required|exists:periods,id',
                'status' => 'required|in:1,0',
            ]);
            // Unicidad: no permitir dos holidays con el mismo nombre, fecha y periodo
            $exists = Holydays::where('name', $validated['name'])
                ->where('date', $validated['date'])
                ->where('period_id', $validated['period_id'])
                ->exists();
            if ($exists) {
                return response()->json(['success' => false, 'message' => 'Ya existe un feriado con ese nombre, fecha y periodo.'], 422);
            }
            $holiday = Holydays::create($validated);
            return response()->json(['success' => true, 'message' => 'Feriado creado correctamente', 'holiday' => $holiday], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Datos inválidos', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al crear el feriado: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $holiday = Holydays::findOrFail($id);
        $periods = Period::pluck('name', 'id');
        return view('admin.holidays.edit', compact('holiday', 'periods'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->merge([
                'name' => trim($request->input('name')),
                'description' => $request->has('description') ? trim($request->input('description')) : null,
            ]);
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'date' => 'required|date',
                'period_id' => 'required|exists:periods,id',
                'status' => 'required|in:1,0',
            ]);
            // Unicidad: no permitir dos holidays con el mismo nombre, fecha y periodo (excepto el actual)
            $exists = Holydays::where('name', $validated['name'])
                ->where('date', $validated['date'])
                ->where('period_id', $validated['period_id'])
                ->where('id', '!=', $id)
                ->exists();
            if ($exists) {
                return response()->json(['success' => false, 'message' => 'Ya existe un feriado con ese nombre, fecha y periodo.'], 422);
            }
            $holiday = Holydays::findOrFail($id);
            $holiday->update($validated);
            return response()->json(['success' => true, 'message' => 'Feriado actualizado correctamente', 'holiday' => $holiday]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Datos inválidos', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar el feriado: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $holiday = Holydays::findOrFail($id);
            $holiday->delete();
            return response()->json(['success' => true, 'message' => 'Feriado eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el feriado: ' . $e->getMessage()], 500);
        }
    }
}
