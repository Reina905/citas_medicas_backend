<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Paciente;

class PacientePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ver pacientes');
    }

    public function view(User $user, Paciente $paciente): bool
    {
        return $user->hasPermissionTo('ver pacientes');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('crear pacientes');
    }

    public function update(User $user, Paciente $paciente): bool
    {
        return $user->hasPermissionTo('editar pacientes');
    }

    public function delete(User $user, Paciente $paciente): bool
    {
        return $user->hasPermissionTo('eliminar pacientes');
    }
}