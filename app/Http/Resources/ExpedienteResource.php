<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpedienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'expediente_id' => $this->expediente_id,
            'paciente' => PacienteResource::make($this->whenLoaded('paciente')),
            'tipo_sangre' => $this->tipo_sangre,
            'alergias' => $this->alergias,
            'condiciones' => $this->condiciones,
            'medicaciones' => $this->medicaciones,
            'notas'=> $this->notas,
        ];
    }
}
