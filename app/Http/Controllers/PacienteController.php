<?php

namespace App\Http\Controllers;

use App\Http\Requests\PacienteRequest;
use App\Http\Requests\PacienteUpdateRequest;
use App\Http\Resources\PacienteResource;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pacientes = Paciente::query();
        $pacientes = $pacientes 
        ->when($request->has('nombre'), fn ($query) => 
            $query->where('nombre', 'like', '%'.$request->input('nombre').'%'))
        ->when($request->has('DUI'), fn ($query) => 
            $query->where('DUI', $request->DUI))
        ->get();

        return PacienteResource::collection($pacientes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PacienteRequest $request)
    {
        $data = $request->validated();

        $paciente = Paciente::create($data);
        $paciente->refresh();

        return response()->json(PacienteResource::make($paciente), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Paciente $paciente)
    {
        return PacienteResource::make($paciente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PacienteUpdateRequest $request, int $paciente)
    {
        $pacienteActualizado = Paciente::findOrFail($paciente);

        $data = $request->validated();

        $pacienteActualizado->update($data);

        return response()->json(PacienteResource::make($pacienteActualizado));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
