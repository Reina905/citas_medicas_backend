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
            'id' => $this->id,
            //'paciente' => $this
            'tipo_sangre' => $this->tipo_sangre,
            'alergias' => $this->alergias,
            'condiciones' => $this->condiciones,
            'medicamentos' => $this->medicamentos,
            'notas'=> $this->notas,
        ];
    }
}
