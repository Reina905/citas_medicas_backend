<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear 20 usuarios
        \App\Models\User::factory(20)->create();

        // Crear 20 pacientes
        \App\Models\Paciente::factory(20)->create();

        // Crear 20 citas (cada una crea usuario y paciente relacionados si no existen)
        \App\Models\Cita::factory(20)->create();
    }
}
