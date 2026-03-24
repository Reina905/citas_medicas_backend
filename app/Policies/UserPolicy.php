<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ver usuarios');
    }
    public function view(User $user, User $model): bool
    {
        return $user->hasPermissionTo('ver usuarios');
    }
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('crear usuarios');
    }
    public function update(User $user, User $model): bool
    {
        return $user->hasPermissionTo('editar usuarios');
    }
    public function delete(User $user, User $model): bool
    {
        return $user->hasPermissionTo('eliminar usuarios');
    }
}