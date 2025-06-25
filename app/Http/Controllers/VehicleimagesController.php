<?php

namespace App\Http\Controllers;

use App\Models\Vehicleimage;
use App\Models\Vehicleimages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleimagesController extends Controller
{
    public function index($vehicleId)
    {
        return Vehicleimages::where('vehicle_id', $vehicleId)->get();
    }

    public function store(Request $request, $vehicleId)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);
        $path = $request->file('image')->store('vehicles', 'public');
        $image = Vehicleimages::create([
            'vehicle_id' => $vehicleId,
            'image_path' => $path,
            'is_profile' => false,
            'status' => true,
        ]);
        return response()->json($image);
    }

    public function destroy($id)
    {
        $image = Vehicleimages::findOrFail($id);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return response()->json(['success' => true]);
    }

    public function setProfile($id)
    {
        $image = Vehicleimages::findOrFail($id);
        Vehicleimages::where('vehicle_id', $image->vehicle_id)->update(['is_profile' => false]);
        $image->is_profile = true;
        $image->save();
        return response()->json(['success' => true]);
    }
}
