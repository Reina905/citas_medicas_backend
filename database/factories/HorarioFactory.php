<?php

namespace Database\Factories;

use App\Models\Horario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Horario>
 */
class HorarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'dia' => fake()->randomElement(['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes']),
            'hora_inicio' => '08:00:00',
            'hora_fin' => '17:00:00',
        ];
    }
}
