<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employeefunction;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // List all employees
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['data' => Employee::all()]);
        }
        $employees = Employee::all();
        return view('admin.employees.index', compact('employees'));
    }

    // Show form to create a new employee
    public function create()
    {
        $functions = Employeefunction::pluck('name', 'id');
        return view('admin.employees.create', compact('functions'));
    }

    // Store a new employee
    public function store(Request $request)
    {
        $request->validate([
            'names' => 'required|string|max:255',
            'lastnames' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:employees,dni',
            'birthday' => 'required|date',
            'license' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employees,email',
            'photo' => 'nullable|file|image|max:2048',
            'phone' => 'required|string|max:20',
            'status' => 'boolean',
            'functions' => 'array',
            'functions.*' => 'exists:employeefunctions,id',
        ]);

        $data = $request->except('functions');
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('employees', 'public');
        }
        $employee = Employee::create($data);

        // Asociar funciones con status activo
        $syncData = [];
        foreach ($request->functions ?? [] as $functionId) {
            $syncData[$functionId] = ['status' => 1];
        }
        $employee->functions()->sync($syncData);

        return response()->json(['message' => 'Empleado creado correctamente']);
    }

    // Show form to edit an employee
    public function edit(Employee $employee)
    {
        $functions = Employeefunction::pluck('name', 'id');
        $employee->load('functions');
        return view('admin.employees.edit', compact('employee', 'functions'));
    }

    // Update an employee
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'names' => 'required|string|max:255',
            'lastnames' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:employees,dni,' . $employee->id,
            'birthday' => 'required|date',
            'license' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employees,email,' . $employee->id,
            'photo' => 'nullable|file|image|max:2048',
            'phone' => 'required|string|max:20',
            'status' => 'boolean',
            'functions' => 'array',
            'functions.*' => 'exists:employeefunctions,id',
        ]);

        $data = $request->except('functions');
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('employees', 'public');
        }
        $employee->update($data);

        $selectedFunctions = $request->functions ?? [];
        $allFunctionIds = Employeefunction::pluck('id')->toArray();

        // Obtener las funciones actuales del empleado
        $currentFunctions = $employee->functions()->pluck('employeefunction_id', 'employeefunction_id')->toArray();

        // Recorrer todas las funciones posibles
        foreach ($allFunctionIds as $functionId) {
            if (in_array($functionId, $selectedFunctions)) {
                // Si está seleccionada, activarla o crearla
                $employee->functions()->updateExistingPivot($functionId, ['status' => 1], false);
                if (!isset($currentFunctions[$functionId])) {
                    $employee->functions()->attach($functionId, ['status' => 1]);
                }
            } else {
                // Si no está seleccionada y existe, desactivarla
                if (isset($currentFunctions[$functionId])) {
                    $employee->functions()->updateExistingPivot($functionId, ['status' => 0]);
                }
            }
        }

        return response()->json(['message' => 'Empleado actualizado correctamente']);
    }

    // Delete an employee
    public function destroy(Employee $employee)
    {
        $employee->functions()->detach();
        $employee->delete();
        return response()->json(['message' => 'Empleado eliminado correctamente']);
    }
}
