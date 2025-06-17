<?php

namespace App\Http\Controllers;

use App\Models\Contracttype;
use Illuminate\Http\Request;

class ContracttypeController extends Controller
{
    // List all contract types
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['data' => Contracttype::all()]);
        }
        $contracttypes = Contracttype::all();
        return view('admin.contract_types.index', compact('contracttypes'));
    }

    // Show form to create a new contract type
    public function create()
    {
        return view('admin.contract_types.create');
    }

    // Store a new contract type
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:contracttypes',
            'description' => 'nullable|string|max:1000',
        ]);

        Contracttype::create($request->all());

        return response()->json(['message' => 'Tipo de contrato creado correctamente']);
    }

    // Show form to edit a contract type
    public function edit(Contracttype $contract_type)
    {
        return view('admin.contract_types.edit', compact('contract_type'));
    }

    // Update a contract type
    public function update(Request $request, Contracttype $contract_type)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:contracttypes,name,'.$contract_type->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $contract_type->update($request->all());

        return response()->json(['message' => 'Tipo de contrato actualizado correctamente']);
    }

    // Delete a contract type
    public function destroy(Contracttype $contract_type)
    {
        $contract_type->delete();
        return response()->json(['message' => 'Tipo de contrato eliminado correctamente']);
    }
}
