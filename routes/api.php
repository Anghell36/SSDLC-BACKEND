<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\AttendanceController;

// Login público
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas con Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Logout y usuario autenticado
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', fn() => auth()->user());

    // Rutas de reportes
    Route::get('/reports', [ReportController::class, 'index']);           // Listar reportes
    Route::post('/reports', [ReportController::class, 'store']);          // Crear reporte
    Route::patch('/reports/{report}', [ReportController::class, 'updateStatus']); // Actualizar estatus

    // Rutas de asistencias
    Route::get('attendances', [AttendanceController::class, 'index']);
    Route::post('attendances', [AttendanceController::class, 'store']);
    Route::get('attendances/{attendance}', [AttendanceController::class, 'show']);

    Route::get('products', [ProductController::class, 'index']);
    Route::post('productos', [ProductController::class, 'store']);
    Route::get('products/export_pdf', [ProductController::class, 'exportPdf']);
    Route::get('products/export-excel', [ProductController::class, 'exportExel']);

    Route::get('personnels', [PersonnelController::class, 'index']);
    Route::get('personnels/export_pdf', [PersonnelController::class, 'exportPdf']);
    Route::get('personnels/export-excel', [PersonnelController::class, 'exportExel']);
});
