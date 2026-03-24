<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    protected $primaryKey = 'paciente_id';
    protected $fillable = [
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'DUI',
        'genero'
    ];


}