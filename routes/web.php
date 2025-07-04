<?php

use App\Http\Controllers\VehicleimagesController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/admin/admin.php';

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/admin', function () {
        return view('admin.index');
    });
});

Route::prefix('admin/vehicles')->group(function () {
    Route::get('{vehicle}/images', [VehicleimagesController::class, 'index']);
    Route::post('{vehicle}/images', [VehicleimagesController::class, 'store']);
    Route::delete('images/{image}', [VehicleimagesController::class, 'destroy']);
    Route::post('images/{image}/set-profile', [VehicleimagesController::class, 'setProfile']);
});
