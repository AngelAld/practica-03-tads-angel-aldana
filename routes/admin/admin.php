<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\BrandmodelController;
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
Route::get('brands/create', [BrandController::class, 'create'])->name('admin.brands.create');
Route::resource('models', BrandmodelController::class)->names('admin.models');