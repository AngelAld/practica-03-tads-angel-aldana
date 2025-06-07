<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Brand;
use App\Models\Brandmodel;
use App\Models\Color;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // List all vehicles
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['data' => Vehicle::all()]);
        }
        $vehicles = Vehicle::all();
        return view('admin.vehicles.index', compact('vehicles'));
    }

    // Show form to create a new vehicle
    public function create()
    {
        $brands = Brand::pluck('name', 'id');
        $models = Brandmodel::pluck('name', 'id');
        $colors = Color::pluck('name', 'id');
        return view('admin.vehicles.create', compact('brands', 'models', 'colors'));
    }

    // Store a new vehicle
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:vehicles,code',
            'plate' => 'required|string|max:255|unique:vehicles,plate',
            'year' => 'required|digits:4|integer',
            'load_capacity' => 'required|integer',
            'description' => 'nullable|string',
            'fuel_capacity' => 'nullable|numeric',
            'ocuppants' => 'nullable|integer',
            'status' => 'boolean',
            'model_id' => 'required|exists:brandmodels,id',
            'color_id' => 'required|exists:colors,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        Vehicle::create($request->all());

        return response()->json(['message' => 'Vehículo creado correctamente']);
    }

    // Show form to edit a vehicle
    public function edit(Vehicle $vehicle)
    {
        $brands = Brand::pluck('name', 'id');
        $models = Brandmodel::pluck('name', 'id');
        $colors = Color::pluck('name', 'id');
        return view('admin.vehicles.edit', compact('vehicle', 'brands', 'models', 'colors'));
    }

    // Update a vehicle
    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:vehicles,code,' . $vehicle->id,
            'plate' => 'required|string|max:255|unique:vehicles,plate,' . $vehicle->id,
            'year' => 'required|digits:4|integer',
            'load_capacity' => 'required|integer',
            'description' => 'nullable|string',
            'fuel_capacity' => 'nullable|numeric',
            'ocuppants' => 'nullable|integer',
            'status' => 'boolean',
            'model_id' => 'required|exists:brandmodels,id',
            'color_id' => 'required|exists:colors,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $vehicle->update($request->all());

        return response()->json(['message' => 'Vehículo actualizado correctamente']);
    }

    // Delete a vehicle
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return response()->json(['message' => 'Vehículo eliminado correctamente']);
    }
}
