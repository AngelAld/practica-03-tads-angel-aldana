<?php

use App\Http\Controllers\PeriodController;
use Illuminate\Support\Facades\Route;

Route::resource('periods', PeriodController::class)->names('admin.periods');
