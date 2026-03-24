<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'id' => $this->id,
            //'paciente' => $this
            //'medico' => $this->description
            'dia' => $this->dia,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
        ];
    }
}

