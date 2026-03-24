<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Expediente;

class ExpedientePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ver expedientes');
    }

    public function view(User $user, Expediente $expediente): bool
    {
        return $user->hasPermissionTo('ver expedientes');
    }

    public function update(User $user, Expediente $expediente): bool
    {
        return $user->hasPermissionTo('editar expedientes');
    }
    public function delete(User $user, Expediente $expediente): bool
    {
        return false;
    }
}