<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\PacienteResource;

class CitaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'cita_id' => $this->cita_id,
            'paciente' => PacienteResource::make($this->whenLoaded('paciente')),
            'doctor' => UserResource::make($this->whenLoaded('user')),
            'dia' => $this->dia,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
        ];
    }
}

