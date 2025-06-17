<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Exception;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $colors = Color::select('id', 'name', 'hex_code')->get();
            return response()->json(['data' => $colors]);
        }
        return view('admin.colors.index');
    }

    public function create()
    {
        try {
            return view('admin.colors.create');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar el formulario de creación.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'hex_code' => 'required|string|max:255',
            ]);

            Color::create($request->only(['name', 'hex_code']));

            return redirect()->route('admin.colors.index')->with('success', 'Color creado correctamente');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al crear el color.');
        }
    }

    public function edit(Color $color)
    {
        try {
            return view('admin.colors.edit', compact('color'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar el formulario de edición.');
        }
    }

    public function update(Request $request, Color $color)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'hex_code' => 'required|string|max:255',
            ]);

            $color->update($request->only(['name', 'hex_code']));

            return redirect()->route('admin.colors.index')->with('success', 'Color actualizado correctamente');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el color.');
        }
    }

    public function destroy(Color $color)
    {
        try {
            $color->delete();
            return redirect()->route('admin.colors.index')->with('success', 'Color eliminado correctamente');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el color.');
        }
    }
}
