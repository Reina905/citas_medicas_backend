<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;
    protected $fillable = [
        'paciente_id',
        'user_id',
        'dia',
        'hora_inicio',
        'hora_fin',
    ];
}
