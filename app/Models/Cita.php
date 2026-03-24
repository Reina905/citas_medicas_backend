<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $primaryKey = 'cita_id';

    public $incrementing = true; 
    protected $keyType = 'int';

    protected $fillable = [
        'paciente_id',
        'user_id',
        'dia',
        'hora_inicio',
        'hora_fin',
    ];

    protected $casts = [
        'dia' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
