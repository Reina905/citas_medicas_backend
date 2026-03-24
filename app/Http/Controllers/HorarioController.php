<?php

namespace App\Http\Controllers;

use App\Http\Requests\HorarioRequest;
use App\Http\Resources\HorarioResource;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Horario::class);
        $horarios = Horario::query();
        $horarios = $horarios
            ->when($request->has('medico_id'), fn($query) =>
                $query->where('user_id', $request->input('medico_id')))
            ->get();

        return HorarioResource::collection($horarios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HorarioRequest $request)
    {
        Gate::authorize('create', Horario::class);
        $data = $request->validated();
        $horario = Horario::create($data);

        return response()->json(HorarioResource::make($horario), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $horario = Horario::findOrFail($id);
        Gate::authorize('view', $horario);

        return response()->json(HorarioResource::make($horario));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HorarioRequest $request, string $id)
    {
        $horario = Horario::findOrFail($id);
        Gate::authorize('update', $horario);

        $data = $request->validated();
        $horario->update($data);

        return response()->json(HorarioResource::make($horario));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $horario = Horario::findOrFail($id);
        Gate::authorize('delete', $horario);

        $horario->delete();

        return response()->json(null, 204);
    }
}
