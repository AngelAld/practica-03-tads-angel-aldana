<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Brandmodel;
use Illuminate\Http\Request;

class BrandmodelController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
        $models = Brandmodel::select(
            'brandmodels.id',
            'brandmodels.name',
            'brandmodels.code',
            'brandmodels.description',
            'b.name as brand_name'
        )
        ->join('brands as b', 'brandmodels.brand_id', '=', 'b.id')
        ->get();

            return response()->json(['data' => $models]);
        }

        return view('admin.brandmodels.index');
    }

    public function create()
    {
        $brands = Brand::pluck('name', 'id');
        return view('admin.brandmodels.create', compact('brands'))->render();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'code' => 'nullable|string|max:50|unique:brandmodels,code',
            'description' => 'nullable|string|max:255',
        ]);

        Brandmodel::create($request->all());

        return response()->json(['message' => 'Modelo creado correctamente']);
    }

    public function edit(Brandmodel $brandmodel)
    {
        $brands = Brand::pluck('name', 'id');
        return view('admin.brandmodels.edit', compact('brandmodel', 'brands'))->render();
    }

    public function update(Request $request, Brandmodel $brandmodel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'code' => 'nullable|string|max:50|unique:brandmodels,code,' . $brandmodel->id,
            'description' => 'nullable|string|max:255',
        ]);

        $brandmodel->update($request->all());

        return response()->json(['message' => 'Modelo actualizado correctamente']);
    }

    public function destroy(Brandmodel $brandmodel)
    {
        $brandmodel->delete();
        return response()->json(['message' => 'Modelo eliminado correctamente']);
    }

}
