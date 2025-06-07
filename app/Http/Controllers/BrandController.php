<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    public function index(Request $request)
    {
            if ($request->ajax()) {
            $brands = Brand::all();
            return response()->json(['data' => $brands]);
        }
        return view('admin.brands.index');
    }
    public function create()
    {
        try {
            $brand = new Brand();
            return view('admin.brands.create', compact('brand'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar crear una nueva marca: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'logo' => 'nullable|image|max:2048'
            ]);

            $brand = new Brand();
            $brand->name = $request->name;
            $brand->description = $request->description;

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('brand_logo', 'public');
                $brand->logo = $path; // Guarda solo 'brand_logo/archivo.png'
            }

            $brand->save();

            return response()->json(['message' => 'Marca creada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la marca: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->delete();
            return redirect()->route('admin.brands.index')->with('success', 'Marca eliminada con éxito.');
        } catch (\Exception $e) {
            return redirect()->route('admin.brands.index')->with('error', 'Ocurrió un error al intentar eliminar la marca. ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            return view('admin.brands.edit', compact('brand'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar editar la marca: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'logo' => 'nullable|image|max:2048'
            ]);

            $brand = Brand::findOrFail($id);
            $brand->name = $request->name;
            $brand->description = $request->description;

            if ($request->hasFile('logo')) {
                // Elimina la imagen anterior si existe
                if ($brand->logo && Storage::exists(str_replace('storage/', 'public/', $brand->logo))) {
                    Storage::delete(str_replace('storage/', 'public/', $brand->logo));
                }
                $path = $request->file('logo')->store('brand_logo', 'public');
                $brand->logo = $path; // Guarda solo 'brand_logo/archivo.png'
            }

            $brand->save();

            return response()->json(['message' => 'Marca actualizada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar la marca: ' . $e->getMessage()], 500);
        }
    }

}
