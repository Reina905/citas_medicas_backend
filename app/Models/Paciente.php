<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    protected $primaryKey = 'paciente_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'DUI',
        'genero'
    ];

    public function expediente()
    {
        return $this->hasOne(Expediente::class, 'paciente_id', 'paciente_id');
    }
}