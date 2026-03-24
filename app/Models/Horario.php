<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    protected $primaryKey = 'horario_id';
    protected $fillable = [
        'user_id',
        'dia',
        'hora_inicio',
        'hora_fin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
