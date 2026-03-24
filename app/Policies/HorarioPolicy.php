<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Horario;

class HorarioPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ver horarios');
    }
    public function view(User $user, Horario $horario): bool
    {
        return $user->hasPermissionTo('ver horarios');
    }
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('crear horarios');
    }
    public function update(User $user, Horario $horario): bool
    {
        return $user->hasPermissionTo('editar horarios');
    }
    public function delete(User $user, Horario $horario): bool
    {
        return $user->hasPermissionTo('eliminar horarios');
    }
}
