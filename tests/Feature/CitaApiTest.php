<?php
// ARCHIVO CORREGIDO - reemplaza tests/Feature/CitaApiTest.php

use App\Models\User;
use App\Models\Paciente;
use App\Models\Cita;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

// CORRECCIÓN 1: uses() debe declararse al inicio, antes de cualquier hook
uses(RefreshDatabase::class);

beforeEach(function () {
    // CORRECCIÓN 2: app()->make resuelve el guard correctamente con Sanctum
    Role::firstOrCreate(['name' => 'doctor', 'guard_name' => 'web']);
});

it('crea una cita correctamente', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre'           => 'Carlos',
        'apellido'         => 'Perez',
        'fecha_nacimiento' => '2000-01-01',
        'DUI'              => '12345678-9',
        'genero'           => 'M',
    ]);

    // CORRECCIÓN 3: actingAs() para autenticar el usuario en la petición
    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'paciente_id' => $paciente->paciente_id,
        'user_id'     => $user->id,
        'dia'         => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin'    => '10:00:00',
    ]);

    $response->assertStatus(201);
    expect(Cita::count())->toBe(1);
});

it('rechaza cita con datos incompletos', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    // CORRECCIÓN 3: actingAs() también aquí para que no falle por 401
    $response = $this->actingAs($user)->postJson('/api/v1/citas', []);

    $response->assertStatus(422);
});

it('actualiza una cita', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre'           => 'Luis',
        'apellido'         => 'Martinez',
        'fecha_nacimiento' => '1990-01-01',
        'DUI'              => '11111111-1',
        'genero'           => 'M',
    ]);

    $cita = Cita::create([
        'paciente_id' => $paciente->paciente_id,
        'user_id'     => $user->id,
        'dia'         => '2026-03-25',
        'hora_inicio' => '08:00:00',
        'hora_fin'    => '09:00:00',
    ]);

    // CORRECCIÓN 3: actingAs() en la petición PUT
    $response = $this->actingAs($user)->putJson("/api/v1/citas/{$cita->cita_id}", [
        'paciente_id' => $paciente->paciente_id,
        'user_id'     => $user->id,
        'dia'         => '2026-03-25',
        'hora_inicio' => '10:00:00',
        'hora_fin'    => '11:00:00',
    ]);

    $response->assertStatus(200);
    $cita->refresh();

    // CORRECCIÓN 4: comparar solo la parte de hora si el cast devuelve datetime completo.
    // Si tu columna es tipo `time`, esto debería funcionar directo.
    // Si es `datetime` o `timestamp`, usa: str_contains($cita->hora_inicio, '10:00:00')
    expect($cita->hora_inicio)->toBe('10:00:00');
});

it('elimina una cita', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre'           => 'Maria',
        'apellido'         => 'Gomez',
        'fecha_nacimiento' => '1992-01-01',
        'DUI'              => '22222222-2',
        'genero'           => 'F',
    ]);

    $cita = Cita::create([
        'paciente_id' => $paciente->paciente_id,
        'user_id'     => $user->id,
        'dia'         => '2026-03-25',
        'hora_inicio' => '07:00:00',
        'hora_fin'    => '08:00:00',
    ]);

    // CORRECCIÓN 3: actingAs() en la petición DELETE
    $response = $this->actingAs($user)->deleteJson("/api/v1/citas/{$cita->cita_id}");

    expect(Cita::count())->toBe(0);
});

it('no permite citas en el mismo horario para el mismo doctor', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    // CORRECCIÓN 5: DUIs con formato válido (mismo largo que el resto de los tests)
    $paciente1 = Paciente::create([
        'nombre'           => 'Paciente',
        'apellido'         => 'Uno',
        'fecha_nacimiento' => '2000-01-01',
        'DUI'              => '33333333-3',
        'genero'           => 'M',
    ]);

    $paciente2 = Paciente::create([
        'nombre'           => 'Paciente',
        'apellido'         => 'Dos',
        'fecha_nacimiento' => '2000-01-01',
        'DUI'              => '44444444-4',
        'genero'           => 'F',
    ]);

    // Primera cita creada directamente en BD (sin HTTP)
    Cita::create([
        'paciente_id' => $paciente1->paciente_id,
        'user_id'     => $user->id,
        'dia'         => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin'    => '10:00:00',
    ]);

    // CORRECCIÓN 3: actingAs() para la segunda cita que debe ser rechazada
    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'paciente_id' => $paciente2->paciente_id,
        'user_id'     => $user->id,
        'dia'         => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin'    => '10:00:00',
    ]);

    $response->assertStatus(422);
});
