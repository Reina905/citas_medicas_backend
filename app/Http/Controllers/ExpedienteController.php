<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpedienteRequest;
use App\Http\Resources\ExpedienteResource;
use App\Models\Expediente;
use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
    public function index(Request $request)
    {
        $expedientes = Expediente::paginate(10); 
        return ExpedienteResource::collection($expedientes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpedienteRequest $request)
    {
        $data = $request->validated();

        $expediente = Expediente::create($data);
        $expediente->refresh();

        return response()->json(ExpedienteResource::make($expediente), 201);
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
