<?php

namespace App\Http\Controllers;

use App\Models\ScheduleShift;
use Illuminate\Http\Request;

class ScheduleShiftController extends Controller
{
    // List all schedule shifts
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['data' => ScheduleShift::all()]);
        }
        $scheduleshifts = ScheduleShift::all();
        return view('admin.schedule_shifts.index', compact('scheduleshifts'));
    }

    // Show form to create a new schedule shift
    public function create()
    {
        return view('admin.schedule_shifts.create');
    }

    // Store a new schedule shift
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:scheduleshifts',
            'description' => 'nullable|string|max:1000',
        ]);

        ScheduleShift::create($request->all());

        return response()->json(['message' => 'Turno de horario creado correctamente']);
    }

    // Show form to edit a schedule shift
    public function edit(ScheduleShift $schedule_shift)
    {
        return view('admin.schedule_shifts.edit', compact('schedule_shift'));
    }

    // Update a schedule shift
    public function update(Request $request, ScheduleShift $schedule_shift)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:scheduleshifts,name,'.$schedule_shift->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $schedule_shift->update($request->all());

        return response()->json(['message' => 'Turno de horario actualizado correctamente']);
    }

    // Delete a schedule shift
    public function destroy(ScheduleShift $schedule_shift)
    {
        $schedule_shift->delete();
        return response()->json(['message' => 'Turno de horario eliminado correctamente']);
    }
}
