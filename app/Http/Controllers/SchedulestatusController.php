<?php

namespace App\Http\Controllers;

use App\Models\Schedulestatus;
use Illuminate\Http\Request;

class SchedulestatusController extends Controller
{
    // List all schedule statuses
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['data' => Schedulestatus::all()]);
        }
        $schedulestatuses = Schedulestatus::all();
        return view('admin.schedule_statuses.index', compact('schedulestatuses'));
    }

    // Show form to create a new schedule status
    public function create()
    {
        return view('admin.schedule_statuses.create');
    }

    // Store a new schedule status
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:schedulestatuses',
            'description' => 'nullable|string|max:1000',
        ]);

        Schedulestatus::create($request->all());

        return response()->json(['message' => 'Estado de horario creado correctamente']);
    }

    // Show form to edit a schedule status
    public function edit(Schedulestatus $schedule_status)
    {
        return view('admin.schedule_statuses.edit', compact('schedule_status'));
    }

    // Update a schedule status
    public function update(Request $request, Schedulestatus $schedule_status)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:schedulestatuses,name,'.$schedule_status->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $schedule_status->update($request->all());

        return response()->json(['message' => 'Estado de horario actualizado correctamente']);
    }

    // Delete a schedule status
    public function destroy(Schedulestatus $schedule_status)
    {
        $schedule_status->delete();
        return response()->json(['message' => 'Estado de horario eliminado correctamente']);
    }
}
