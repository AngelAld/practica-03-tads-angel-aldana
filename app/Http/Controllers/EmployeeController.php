<?php

namespace App\Http\Controllers;

use App\Models\Employee;
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
        return view('admin.employees.create');
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
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('employees', 'public');
        }

        Employee::create($data);

        return response()->json(['message' => 'Empleado creado correctamente']);
    }

    // Show form to edit an employee
    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
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
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('employees', 'public');
        }

        $employee->update($data);

        return response()->json(['message' => 'Empleado actualizado correctamente']);
    }

    // Delete an employee
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(['message' => 'Empleado eliminado correctamente']);
    }
}
