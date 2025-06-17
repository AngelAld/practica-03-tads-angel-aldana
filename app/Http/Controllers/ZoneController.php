<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Zone;
use App\Models\Zonecoords;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index(Request $request)
    {
        $zones = Zone::with('district')->get();
        if ($request->ajax()) {
            return response()->json([
                'data' => $zones,
            ]);
        } else {
            return view('admin.zones.index', compact('zones'));
        }
    }

    public function create()
    {
        $districts = District::pluck('name', 'id');
        return view('admin.zones.create', compact('districts'));
    }

    public function show($id)
    {
        $zone = Zone::with('district', 'zone_coordinates')->findOrFail($id);
        return view('admin.zones.show', compact('zone'));
    }

    // Agregar varias coordenadas a una zona
    public function storeCoords(Request $request)
    {
        $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'coords' => 'required|array',
            'coords.*.lat' => 'required|numeric',
            'coords.*.lng' => 'required|numeric',
        ]);

        try {
            $zone = Zone::findOrFail($request->zone_id);
            $zone->updateCoordinates($request->coords);
            return response()->json(['success' => true, 'message' => 'Coordenadas actualizadas correctamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al agregar coordenadas: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'load_requirement' => 'nullable|string|max:255',
            'district_id' => 'required|exists:districts,id',
        ]);

        Zone::create([
            'name' => $request->name,
            'description' => $request->description,
            'load_requirement' => $request->load_requirement,
            'district_id' => $request->district_id,
        ]);
        return redirect()->route('admin.zones.index')->with('success', 'Zona creada correctamente');
    }

    public function edit($id)
    {
        $districts = District::pluck('name', 'id');
        $zone = Zone::findOrFail($id);
        return view('admin.zones.edit', compact('districts', 'zone'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'load_requirement' => 'nullable|string|max:255',
            'district_id' => 'required|exists:districts,id',
        ]);

        $zone = Zone::findOrFail($id);
        $zone->update([
            'name' => $request->name,
            'description' => $request->description,
            'load_requirement' => $request->load_requirement,
            'district_id' => $request->district_id,
        ]);
        return redirect()->route('admin.zones.index')->with('success', 'Zona actualizada correctamente');
    }

    public function destroy($id)
    {
        $zone = Zone::findOrFail($id);
        $zone->delete();
        return redirect()->route('admin.zones.index')->with('success', 'Zona eliminada correctamente');
    }
}
