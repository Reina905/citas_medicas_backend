<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ExpedienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'paciente_id' => [
                'required',
                'exists:pacientes,paciente_id',
                'unique:expedientes,paciente_id' 
            ],
            'tipo_sangre' => 'required|string|max:15',
            'alergias' => 'nullable|string',
            'condiciones' => 'nullable|string',
            'medicaciones' => 'nullable|string',
            'notas' => 'nullable|string',
        ];
    }
}
