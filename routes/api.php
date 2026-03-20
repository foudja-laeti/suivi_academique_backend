<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\UeController;
use App\Http\Controllers\EcController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\ProgrammationController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnseigneController; // ✅

Route::post('/login', [AuthController::class, 'login']);
Route::apiResource("personnels", PersonnelController::class);
Route::apiResource("filieres", FiliereController::class, [
    'only' => ['index', 'store', 'show', 'update', 'destroy']
]);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource("niveaux", NiveauController::class);
    Route::apiResource("Ue", UeController::class);
    Route::apiResource("ec", EcController::class);
    Route::apiResource("salles", SalleController::class);
    Route::apiResource("programmations", ProgrammationController::class);

    Route::post('/enseignes', [EnseigneController::class, 'store']);
    Route::put('/enseignes/{code_pers}/{code_ec}', [EnseigneController::class, 'update']);
    Route::delete('/enseignes/{code_pers}/{code_ec}', [EnseigneController::class, 'destroy']);
});
