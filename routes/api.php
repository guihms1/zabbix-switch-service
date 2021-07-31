<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    SwitchController
};

Route::get('switchs', [SwitchController::class, 'index'])->name('switchs.index');
