<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Brand;
use App\Models\Brandmodel;
use App\Models\Color;
use App\Models\Vehicletype; // Agrega esta línea
use App\Models\Vehicleimages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    // List all vehicles
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $vehicles = Vehicle::with(['model', 'color', 'brand', 'type'])->get();
            $data = $vehicles->map(function ($vehicle) {
                return [
                    'id' => $vehicle->id,
                    'name' => $vehicle->name,
                    'code' => $vehicle->code,
                    'plate' => $vehicle->plate,
                    'year' => $vehicle->year,
                    'load_capacity' => $vehicle->load_capacity,
                    'description' => $vehicle->description,
                    'fuel_capacity' => $vehicle->fuel_capacity,
                    'ocuppants' => $vehicle->ocuppants,
                    'status' => $vehicle->status ? 'Activo' : 'Inactivo',
                    'model' => $vehicle->model?->name,
                    'color' => $vehicle->color?->name,
                    'brand' => $vehicle->brand?->name,
                    'type' => $vehicle->type?->name,
                    // agrega aquí los campos para editar/eliminar si los necesitas
                ];
            });
            return response()->json(['data' => $data]);
        }
        $vehicles = Vehicle::with(['model', 'color', 'brand', 'type'])->get();
        return view('admin.vehicles.index', compact('vehicles'));
    }

    // Show form to create a new vehicle
    public function create()
    {
        $brands = Brand::pluck('name', 'id');
        $models = Brandmodel::pluck('name', 'id');
        $colors = Color::pluck('name', 'id');
        $types = Vehicletype::pluck('name', 'id'); // Agrega esta línea
        return view('admin.vehicles.create', compact('brands', 'models', 'colors', 'types'));
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
            'type_id' => 'required|exists:vehicletypes,id', // Agrega esta línea
            'images.*' => 'nullable|image|max:2048',
            'portada' => 'nullable|integer',
        ]);

        DB::transaction(function () use ($request) {
            $vehicle = Vehicle::create($request->all());

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $idx => $img) {
                    $path = $img->store('vehicles', 'public');
                    Vehicleimages::create([
                        'vehicle_id' => $vehicle->id,
                        'image_path' => $path,
                        'is_profile' => $idx == $request->portada,
                        'status' => true,
                    ]);
                }
            }
        });

        return response()->json(['message' => 'Vehículo creado correctamente']);
    }

    // Show form to edit a vehicle
    public function edit(Vehicle $vehicle)
    {
        $brands = Brand::pluck('name', 'id');
        $models = Brandmodel::pluck('name', 'id');
        $colors = Color::pluck('name', 'id');
        $types = Vehicletype::pluck('name', 'id'); // Agrega esta línea
        return view('admin.vehicles.edit', compact('vehicle', 'brands', 'models', 'colors', 'types'));
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
            'type_id' => 'required|exists:vehicletypes,id', // Agrega esta línea
            'images.*' => 'nullable|image|max:2048',
            'portada' => 'nullable|integer',
        ]);

        DB::transaction(function () use ($request, $vehicle) {
            $vehicle->update($request->all());

            // Si hay imágenes nuevas, las agregamos
            $newImages = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $idx => $img) {
                    $path = $img->store('vehicles', 'public');
                    $newImages[] = Vehicleimages::create([
                        'vehicle_id' => $vehicle->id,
                        'image_path' => $path,
                        'is_profile' => false, // Se ajusta después
                        'status' => true,
                    ]);
                }
            }

            // Actualizar portada
            // Si la portada es una imagen nueva
            if ($request->filled('portada') && isset($newImages[$request->portada])) {
                // Desmarcar todas
                Vehicleimages::where('vehicle_id', $vehicle->id)->update(['is_profile' => false]);
                // Marcar la nueva como portada
                $newImages[$request->portada]->is_profile = true;
                $newImages[$request->portada]->save();
            }
            // Si la portada es una imagen existente
            elseif ($request->filled('portada_existing_id')) {
                Vehicleimages::where('vehicle_id', $vehicle->id)->update(['is_profile' => false]);
                Vehicleimages::where('id', $request->portada_existing_id)->update(['is_profile' => true]);
            }
        });

        return response()->json(['message' => 'Vehículo actualizado correctamente']);
    }

    // Delete a vehicle
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return response()->json(['message' => 'Vehículo eliminado correctamente']);
    }
}
