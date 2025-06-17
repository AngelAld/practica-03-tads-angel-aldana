<?php

namespace App\Http\Controllers;

use App\Models\Vehicletype;
use Illuminate\Http\Request;

class VehicletypeController extends Controller
{
    // List all vehicle types
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['data' => Vehicletype::all()]);
        }
        $vehicletypes = Vehicletype::all();
        return view('admin.vehicle_types.index', compact('vehicletypes'));
    }

    // Show form to create a new vehicle type
    public function create()
    {
        return view('admin.vehicle_types.create');
    }

    // Store a new vehicle type
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        Vehicletype::create($request->all());

        return response()->json(['message' => 'Tipo de vehículo creado correctamente']);
    }

    // Show form to edit a vehicle type
    public function edit(Vehicletype $vehicle_type)
    {
        return view('admin.vehicle_types.edit', compact('vehicle_type'));
    }

    // Update a vehicle type
    public function update(Request $request, Vehicletype $vehicle_type)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $vehicle_type->update($request->all());

        return response()->json(['message' => 'Tipo de vehículo actualizado correctamente']);
    }

    // Delete a vehicle type
    public function destroy(Vehicletype $vehicle_type)
    {
        $vehicle_type->delete();
        return response()->json(['message' => 'Tipo de vehículo eliminado correctamente']);
    }
}
