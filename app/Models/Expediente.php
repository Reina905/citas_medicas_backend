<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    use HasFactory;
    protected $fillable = [
        'paciente_id',
        'tipo_sangre',
        'alergias',
        'condiciones',
        'medicamentos',
        'notas'
    ];
}
