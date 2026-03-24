<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cita;

class CitaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ver citas');
    }

    public function view(User $user, Cita $cita): bool
    {
        return $user->hasPermissionTo('ver citas');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('crear citas');
    }

    public function update(User $user, Cita $cita): bool
    {
        return $user->hasPermissionTo('editar citas');
    }

    public function delete(User $user, Cita $cita): bool
    {
        return $user->hasPermissionTo('eliminar citas');
    }
}