<?php

namespace App\Http\Controllers;

use App\Http\Requests\CitaRequest;
use App\Http\Resources\CitaResource;
use App\Models\Cita;
use App\Models\User;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index(Request $request)
    {
        $citas = Cita::with(['paciente', 'user'])->paginate();
        return CitaResource::collection($citas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CitaRequest $request)
    {
        $data = $request->validated();

        $user = User::findOrFail($data['user_id']);
        if ($user->rol !== 'doctor') {
            return response()->json(['message' => 'El usuario debe ser doctor'], 422);
        }

        if ($user->rol === 'doctor') {

            $existeConflicto = Cita::where('user_id', $data['user_id'])
                ->where('dia', $data['dia'])
                ->where(function ($query) use ($data) {
                    $query->where('hora_inicio', '<', $data['hora_fin'])
                        ->where('hora_fin', '>', $data['hora_inicio']);
                })
                ->exists();

            if ($existeConflicto) {
                return response()->json([
                    'message' => 'El doctor ya tiene una cita en ese horario'
                ], 422);
            }
        }

        $cita = Cita::create($data);

        // Cargar relaciones antes de pasarlo al Resource
        $cita->load(['paciente', 'user']);

        return response()->json(CitaResource::make($cita), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CitaRequest $request, string $id)
    {
        $cita = Cita::findOrFail($id);
        $data = $request->validated();

        $user = User::findOrFail($data['user_id']);
        if ($user->rol !== 'doctor') {
            return response()->json(['message' => 'El usuario debe ser doctor'], 422);
        }

        if ($user->rol === 'doctor') {

            $existeConflicto = Cita::where('user_id', $data['user_id'])
                ->where('dia', $data['dia'])
                ->where('cita_id', '!=', $cita->cita_id) 
                ->where(function ($query) use ($data) {
                    $query->where('hora_inicio', '<', $data['hora_fin'])
                        ->where('hora_fin', '>', $data['hora_inicio']);
                })
                ->exists();

            if ($existeConflicto) {
                return response()->json([
                    'message' => 'El doctor ya tiene una cita en ese horario'
                ], 422);
            }
        }

        $cita->update($data);

        // Cargar relaciones antes de pasarlo al Resource
        $cita->load(['paciente', 'user']);

        return response()->json(CitaResource::make($cita), 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cita = Cita::findOrFail($id);

        $cita->delete();

        return response()->json(null, 204);
    }
}
