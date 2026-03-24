<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HorarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'horario_id' => $this->horario_id,
            'doctor' => UserResource::make($this->whenLoaded('user')),
            'dia' => $this->dia,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
        ];
    }
}




