<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Brandmodel;
use Illuminate\Http\Request;

class BrandmodelController extends Controller
{
    public function index()
    {
        $models = Brandmodel::select(
            'brandmodels.id',
            'brandmodels.name as name',
            'brandmodels.code',
            'brandmodels.description',
            'b.name as brand_name',
            'brandmodels.created_at',
            'brandmodels.updated_at'
        )
        ->join('brands as b', 'brandmodels.brand_id', '=', 'b.id')
        ->get();

        return view('admin.brandmodels.index', compact('models'));
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
            'code' => 'nullable|string|max:50',
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
            'code' => 'nullable|string|max:50',
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
