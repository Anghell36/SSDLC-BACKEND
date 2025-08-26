<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class AttendanceController extends Controller
{
    /**
     * Listar asistencias del usuario autenticado (paginado).
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $attendances = Attendance::where('user_id', $user->id)
            ->latest()
            ->paginate(12);

        $attendances->getCollection()->transform(function ($a) {
            $a->photo_url = $a->photo_url ?? Storage::url($a->photo_path);
            return $a;
        });

        return response()->json($attendances);
    }

    /**
     * Guardar nueva asistencia con validación inline.
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        // Validación inline (evita crear FormRequest)
        $validated = $request->validate([
            'photo' => ['required', 'file', 'image', 'max:5120'], // 5MB
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            
        ], [
            'photo.required' => 'Se requiere una foto de evidencia.',
            'photo.image' => 'El archivo debe ser una imagen.',
            'photo.max' => 'La foto no puede exceder los 5 MB.',
        ]);

        // Guardar archivo en disco 'public' en carpeta attendances
        $file = $request->file('photo');
        $filename = Str::random(20) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('attendances', $filename, 'public');

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'photo_path' => $path,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
        ]);

        $attendance->photo_url = Storage::url($attendance->photo_path);

        return response()->json([
            'message' => 'Asistencia guardada correctamente.',
            'attendance' => $attendance,
        ], 201);
    }

    /**
     * Mostrar una asistencia (solo si pertenece al usuario).
     */
    public function show(Request $request, Attendance $attendance): JsonResponse
    {
        $user = $request->user();

        if ($attendance->user_id !== $user->id) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $attendance->photo_url = $attendance->photo_url ?? Storage::url($attendance->photo_path);

        return response()->json($attendance);
    }
}
