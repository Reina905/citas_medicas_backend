<?php

namespace Database\Factories;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cita>
 */
class CitaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $horaInicio = fake()->dateTimeBetween('08:00', '18:00');
        return [
            'paciente_id' => Paciente::factory(),
            'user_id' => User::factory(),
            'dia' => fake()->dateTimeBetween('now', '+2 month')->format('Y-m-d'),
            'hora_inicio' => $horaInicio->format('H:i:s'),
            'hora_fin' => (clone $horaInicio)->modify('+30 minutes')->format('H:i:s'),
        ];
    }
}
