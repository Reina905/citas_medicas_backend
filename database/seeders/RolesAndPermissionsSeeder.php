<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar caché
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        // Usuarios
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);

        // Pacientes
        Permission::create(['name' => 'ver pacientes']);
        Permission::create(['name' => 'crear pacientes']);
        Permission::create(['name' => 'editar pacientes']);
        Permission::create(['name' => 'eliminar pacientes']);

        // Expedientes
        Permission::create(['name' => 'ver expedientes']);
        Permission::create(['name' => 'editar expedientes']);

        // Citas
        Permission::create(['name' => 'ver citas']);
        Permission::create(['name' => 'crear citas']);
        Permission::create(['name' => 'editar citas']);
        Permission::create(['name' => 'eliminar citas']);

        // Crear roles y asignar permisos
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $doctor = Role::create(['name' => 'doctor']);
        $doctor->givePermissionTo([
            'ver pacientes',
            'crear pacientes',
            'editar pacientes',
            'ver expedientes',
            'editar expedientes',
            'ver citas',
            'crear citas',
            'editar citas',
        ]);

        $asistente = Role::create(['name' => 'asistente']);
        $asistente->givePermissionTo([
            'ver pacientes',
            'crear pacientes',
            'editar pacientes',
            'ver expedientes',
            'ver citas',
            'crear citas',
            'editar citas',
        ]);
    }
}
