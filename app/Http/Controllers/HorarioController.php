<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index(Request $request)
    {
        $horarios = Horario::query();
        $horarios = $horarios 
        ->when($request->has('dia'), fn ($query) => 
            $query->where('dia', 'like', '%'.$request->input('dia').'%'))
        ->get();

        return response()->json($horarios, 200);
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
    public function update(Request $request, int $paciente)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
