<?php

namespace App\Http\Controllers;

use App\Models\Employeefunction;
use Illuminate\Http\Request;

class EmployeefunctionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $functions = Employeefunction::all();
            return response()->json(['data' => $functions]);
        }
        return view('admin.employee_functions.index');
    }

    public function create()
    {
        return view('admin.employee_functions.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:employeefunctions,name',
                'description' => 'nullable|string|max:255',
            ]);
            $function = Employeefunction::create($validated);
            return response()->json(['success' => true, 'message' => 'Función creada correctamente', 'function' => $function], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Datos inválidos', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al crear la función: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $function = Employeefunction::findOrFail($id);
        return view('admin.employee_functions.edit', compact('function'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:employeefunctions,name',
                'description' => 'nullable|string|max:255',
            ]);
            $function = Employeefunction::findOrFail($id);
            $function->update($validated);
            return response()->json(['success' => true, 'message' => 'Función actualizada correctamente', 'function' => $function]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Datos inválidos', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar la función: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $function = Employeefunction::findOrFail($id);
            $function->delete();
            return response()->json(['success' => true, 'message' => 'Función eliminada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar la función: ' . $e->getMessage()], 500);
        }
    }
}
