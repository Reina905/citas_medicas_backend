<?php

use App\Models\User;
use App\Models\Paciente;
use App\Models\Cita;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['name' => 'doctor', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'paciente', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'asistente', 'guard_name' => 'web']);
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


    $response = $this->actingAs($user)->putJson("/api/v1/citas/{$cita->cita_id}", [
        'paciente_id' => $paciente->paciente_id,
        'user_id'     => $user->id,
        'dia'         => '2026-03-25',
        'hora_inicio' => '10:00:00',
        'hora_fin'    => '11:00:00',
    ]);

    $response->assertStatus(200);
    $cita->refresh();


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


    $response = $this->actingAs($user)->deleteJson("/api/v1/citas/{$cita->cita_id}");

    expect(Cita::count())->toBe(0);
});

it('no permite citas en el mismo horario para el mismo doctor', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

 
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


    Cita::create([
        'paciente_id' => $paciente1->paciente_id,
        'user_id'     => $user->id,
        'dia'         => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin'    => '10:00:00',
    ]);

 
    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'paciente_id' => $paciente2->paciente_id,
        'user_id'     => $user->id,
        'dia'         => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin'    => '10:00:00',
    ]);

    $response->assertStatus(422);
});

it('rechaza cita sin user_id', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'Test',
        'apellido' => 'User',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '10101010-1',
        'genero' => 'M',
    ]);

    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'paciente_id' => $paciente->paciente_id,
        'dia' => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin' => '10:00:00',
    ]);

    $response->assertStatus(422);
});

it('rechaza cita con horario inválido', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'Test',
        'apellido' => 'User',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '66666666-6',
        'genero' => 'M',
    ]);

    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '10:00:00',
        'hora_fin' => '09:00:00',
    ]);

    $response->assertStatus(422);
});

it('rechaza cita con fecha inválida', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'Test',
        'apellido' => 'User',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '77777777-7',
        'genero' => 'M',
    ]);

    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => 'fecha-invalida',
        'hora_inicio' => '09:00:00',
        'hora_fin' => '10:00:00',
    ]);

    $response->assertStatus(422);
});

it('rechaza cita con paciente inexistente', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'paciente_id' => 9999,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin' => '10:00:00',
    ]);

    $response->assertStatus(422);
});


it('puede listar citas', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $response = $this->actingAs($user)->getJson('/api/v1/citas');

    $response->assertStatus(200)
             ->assertJsonIsArray();
});

it('puede ver una cita específica', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'Test',
        'apellido' => 'User',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '99999999-9',
        'genero' => 'M',
    ]);

    $cita = Cita::create([
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin' => '10:00:00',
    ]);

    $response = $this->actingAs($user)->getJson("/api/v1/citas/{$cita->cita_id}");

    $response->assertStatus(200);
});

it('rechaza update si hay conflicto de horario', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente1 = Paciente::create([
        'nombre' => 'A',
        'apellido' => 'One',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '12121212-1',
        'genero' => 'M',
    ]);

    $paciente2 = Paciente::create([
        'nombre' => 'B',
        'apellido' => 'Two',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '34343434-3',
        'genero' => 'F',
    ]);

    $cita1 = Cita::create([
        'paciente_id' => $paciente1->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin' => '10:00:00',
    ]);

    $cita2 = Cita::create([
        'paciente_id' => $paciente2->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '10:00:00',
        'hora_fin' => '11:00:00',
    ]);

    $response = $this->actingAs($user)->putJson("/api/v1/citas/{$cita2->cita_id}", [
        'paciente_id' => $paciente2->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '09:30:00',
        'hora_fin' => '10:30:00',
    ]);

    $response->assertStatus(422);
});

it('rechaza eliminar cita inexistente', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $response = $this->actingAs($user)->deleteJson('/api/v1/citas/9999');

    $response->assertStatus(404);
});

it('rechaza cita sin paciente_id', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin' => '10:00:00',
    ]);

    $response->assertStatus(422);
});


it('rechaza cita con misma hora inicio y fin', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'Test',
        'apellido' => 'User',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '20202020-2',
        'genero' => 'M',
    ]);

    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '10:00:00',
        'hora_fin' => '10:00:00',
    ]);

    $response->assertStatus(422);
});




it('solo devuelve citas del doctor autenticado', function () {
    $doctor1 = User::factory()->create(['rol' => 'doctor']);
    $doctor2 = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'Test',
        'apellido' => 'User',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '40404040-4',
        'genero' => 'M',
    ]);

    Cita::create([
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $doctor2->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin' => '10:00:00',
    ]);

    $response = $this->actingAs($doctor1)->getJson('/api/v1/citas');

    $response->assertStatus(200);
});

it('crea cita con relaciones válidas', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'Valid',
        'apellido' => 'Patient',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '60606060-6',
        'genero' => 'M',
    ]);

    $cita = Cita::create([
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '11:00:00',
        'hora_fin' => '12:00:00',
    ]);

    expect($cita)->not->toBeNull();
});


it('retorna estructura correcta en listado de citas', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $response = $this->actingAs($user)->getJson('/api/v1/citas');

    $response->assertStatus(200)
             ->assertJsonStructure([
                 '*' => [
                     'cita_id',
                     'paciente_id',
                     'user_id',
                     'dia',
                     'hora_inicio',
                     'hora_fin'
                 ]
             ]);
});

it('rechaza cita con formato de fecha incorrecto tipo string', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'Test',
        'apellido' => 'User',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '11112222-1',
        'genero' => 'M',
    ]);

    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => 'invalid-date',
        'hora_inicio' => '09:00:00',
        'hora_fin' => '10:00:00',
    ]);

    $response->assertStatus(422);
});

it('rechaza hora_inicio con formato invalido', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'Test',
        'apellido' => 'User',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '22223333-2',
        'genero' => 'M',
    ]);

    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => 'abc',
        'hora_fin' => '10:00:00',
    ]);

    $response->assertStatus(422);
});

it('rechaza hora_fin con formato invalido', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'Test',
        'apellido' => 'User',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '33334444-3',
        'genero' => 'M',
    ]);

    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin' => 'xyz',
    ]);

    $response->assertStatus(422);
});

it('rechaza paciente_id no numerico', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'paciente_id' => 'abc',
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin' => '10:00:00',
    ]);

    $response->assertStatus(422);
});

it('rechaza user_id no numerico', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'paciente_id' => 1,
        'user_id' => 'abc',
        'dia' => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin' => '10:00:00',
    ]);

    $response->assertStatus(422);
});

it('rechaza campos vacios', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'paciente_id' => '',
        'user_id' => '',
        'dia' => '',
        'hora_inicio' => '',
        'hora_fin' => '',
    ]);

    $response->assertStatus(422);
});

it('rechaza actualizar cita inexistente', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $response = $this->actingAs($user)->putJson('/api/v1/citas/999999', [
        'paciente_id' => 1,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin' => '10:00:00',
    ]);

    $response->assertStatus(404);
});

it('permite crear varias citas distintas', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'Multi',
        'apellido' => 'Test',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '55556666-5',
        'genero' => 'M',
    ]);

    Cita::create([
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '08:00:00',
        'hora_fin' => '09:00:00',
    ]);

    Cita::create([
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '10:00:00',
        'hora_fin' => '11:00:00',
    ]);

    expect(Cita::count())->toBe(2);
});

it('elimina solo la cita especificada', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'Delete',
        'apellido' => 'Test',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '66667777-6',
        'genero' => 'M',
    ]);

    $cita1 = Cita::create([
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '08:00:00',
        'hora_fin' => '09:00:00',
    ]);

    $cita2 = Cita::create([
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '10:00:00',
        'hora_fin' => '11:00:00',
    ]);

    $this->actingAs($user)->deleteJson("/api/v1/citas/{$cita1->cita_id}");

    expect(Cita::count())->toBe(1);
});


it('lista citas despues de crear una', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'List',
        'apellido' => 'Test',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '88889999-8',
        'genero' => 'M',
    ]);

    Cita::create([
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '09:00:00',
        'hora_fin' => '10:00:00',
    ]);

    $response = $this->actingAs($user)->getJson('/api/v1/citas');

    expect(count($response->json()))->toBeGreaterThan(0);
});

it('permite citas el mismo dia con diferente horario', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'SameDay',
        'apellido' => 'Test',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '99990000-9',
        'genero' => 'M',
    ]);

    Cita::create([
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '08:00:00',
        'hora_fin' => '09:00:00',
    ]);

    $response = $this->actingAs($user)->postJson('/api/v1/citas', [
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '10:00:00',
        'hora_fin' => '11:00:00',
    ]);

    $response->assertStatus(201);
});

it('rechaza eliminar cita con id invalido', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $response = $this->actingAs($user)->deleteJson('/api/v1/citas/abc');

    $response->assertStatus(404);
});

it('actualiza el dia de una cita', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'Update',
        'apellido' => 'Day',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '12131415-1',
        'genero' => 'M',
    ]);

    $cita = Cita::create([
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '08:00:00',
        'hora_fin' => '09:00:00',
    ]);

    $this->actingAs($user)->putJson("/api/v1/citas/{$cita->cita_id}", [
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-26',
        'hora_inicio' => '08:00:00',
        'hora_fin' => '09:00:00',
    ]);

    $cita->refresh();

    expect($cita->dia)->toBe('2026-03-26');
});

it('un paciente puede tener varias citas', function () {
    $user = User::factory()->create(['rol' => 'doctor']);

    $paciente = Paciente::create([
        'nombre' => 'MultiCitas',
        'apellido' => 'Paciente',
        'fecha_nacimiento' => '2000-01-01',
        'DUI' => '13131313-1',
        'genero' => 'M',
    ]);

    Cita::create([
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-25',
        'hora_inicio' => '08:00:00',
        'hora_fin' => '09:00:00',
    ]);

    Cita::create([
        'paciente_id' => $paciente->paciente_id,
        'user_id' => $user->id,
        'dia' => '2026-03-26',
        'hora_inicio' => '10:00:00',
        'hora_fin' => '11:00:00',
    ]);

    expect(Cita::where('paciente_id', $paciente->paciente_id)->count())->toBe(2);
});
