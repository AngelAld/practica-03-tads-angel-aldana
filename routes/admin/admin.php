<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\BrandmodelController;
use App\Http\Controllers\ColorController;
use Illuminate\Support\Facades\Route;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/admin', function () {
        return view('admin.index');
    });
    // Aquí puedes agregar más rutas administrativas
});


Route::resource('brands', BrandController::class)->names('admin.brands');
Route::resource('brandmodels', BrandmodelController::class)->names('admin.brandmodels');
Route::resource('colors', ColorController::class)->names('admin.colors');
Route::resource('employees', \App\Http\Controllers\EmployeeController::class)->names('admin.employees');
Route::resource('vehicles', \App\Http\Controllers\VehicleController::class)->names('admin.vehicles');
Route::resource('periods', \App\Http\Controllers\PeriodController::class)->names('admin.periods');

