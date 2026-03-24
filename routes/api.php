<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PacienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('v1/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);

    Route::get('pacientes', [PacienteController::class,'index']);
    Route::post('pacientes', [PacienteController::class,'store']);
    Route::get('/pacientes/{paciente}', [PacienteController::class, 'show']);
    Route::patch('/pacientes/{paciente}', [PacienteController::class, 'update']);
});