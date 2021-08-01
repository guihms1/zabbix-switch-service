<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    SwitchController
};

Route::get('switchs/{switchBrand}', [SwitchController::class, 'show'])->name('switchs.show');
