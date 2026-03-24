<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\PacienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('v1/login', [AuthController::class, 'login']);


//Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

Route::group(['prefix' => 'v1'], function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);

    Route::get('pacientes', [PacienteController::class,'index']);
    Route::post('pacientes', [PacienteController::class,'store']);
    Route::get('/pacientes/{paciente}', [PacienteController::class, 'show']);
    Route::patch('/pacientes/{paciente}', [PacienteController::class, 'update']);

    Route::get('horarios', [HorarioController::class,'index']);
    Route::post('horarios', [HorarioController::class,'store']);

    Route::get('expedientes', [ExpedienteController::class,'index']);
    Route::post('expedientes', [ExpedienteController::class,'store']);

    Route::get('citas', [CitaController::class, 'index']); 
    Route::post('citas', [CitaController::class, 'store']); 
    Route::put('citas/{id}', [CitaController::class, 'update']);
    Route::delete('citas/{id}', [CitaController::class, 'destroy']);
    Route::get('citas/{id}', [CitaController::class, 'show']);
});
