<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PacienteUpdateRequest extends FormRequest
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
            'nombre' => ['string', 'min:3', 'max:100'],
            'apellido'=> ['string', 'min:3', 'max:100'],
            'fecha_nacimiento' => ['date', 'before:today'],
            'DUI' => ['string', 'unique:pacientes,dui', 'regex:/^\d{8}-\d$/'],
            'genero' => ['string', 'in:femenino,masculino,otro'],
        ];
    }
}

