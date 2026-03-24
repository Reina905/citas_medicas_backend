<?php

namespace App\Http\Controllers;

use App\Http\Requests\HorarioRequest;
use App\Http\Resources\HorarioResource;
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

        return HorarioResource::collection($horarios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HorarioRequest $request)
    {
        $data = $request->validated();

        $horario = Horario::create($data);
        $horario->refresh();

        return response()->json(HorarioResource::make($horario), 201);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
