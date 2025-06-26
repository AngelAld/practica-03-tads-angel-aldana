<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\BrandmodelController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\VehicletypeController;
use App\Http\Controllers\ScheduleShiftController;
use App\Http\Controllers\ContracttypeController;
use App\Http\Controllers\DetalleHorarioMantenimientoController;
use App\Http\Controllers\HorarioMantenimientoController;
use App\Http\Controllers\MantenimientoController;
use Illuminate\Support\Facades\Route;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/admin', function () {
        return view('admin.index');
    });
    Route::resource('mantenimientos', \App\Http\Controllers\MantenimientoController::class)->names('admin.mantenimientos');
});


Route::resource('brands', BrandController::class)->names('admin.brands');


// MANTENIMIENTOS


Route::resource('mantenimientos', MantenimientoController::class)->names('admin.mantenimientos');
Route::resource('mantenimientos.horarios', HorarioMantenimientoController::class)
    ->names('admin.mantenimientos.horarios');
Route::resource('mantenimientos.horarios.detalles', DetalleHorarioMantenimientoController::class)
    ->names('admin.mantenimientos.horarios.detalles');



// FIM DE LOS MANTENIMIENTOS


Route::resource('brandmodels', BrandmodelController::class)->names('admin.brandmodels');
Route::resource('colors', ColorController::class)->names('admin.colors');
Route::resource('employees', \App\Http\Controllers\EmployeeController::class)->names('admin.employees');

Route::resource('vehicle_types', VehicleTypeController::class)->names('admin.vehicle_types');
Route::resource('schedule_shifts', ScheduleShiftController::class)->names('admin.schedule_shifts');
Route::resource('contract_types', ContracttypeController::class)->names('admin.contract_types');
Route::resource('schedule_statuses', \App\Http\Controllers\SchedulestatusController::class)->names('admin.schedule_statuses');

Route::resource('vehicles', \App\Http\Controllers\VehicleController::class)->names('admin.vehicles');
Route::resource('periods', \App\Http\Controllers\PeriodController::class)->names('admin.periods');


Route::resource('zones', \App\Http\Controllers\ZoneController::class)->names('admin.zones');
Route::post('zones/store-coords', [\App\Http\Controllers\ZoneController::class, 'storeCoords'])->name('admin.zones.storeCoords');

Route::resource('employee_functions', \App\Http\Controllers\EmployeeFunctionController::class)->names('admin.employee_functions');

Route::resource('holidays', \App\Http\Controllers\HolydaysController::class)->names('admin.holidays');
