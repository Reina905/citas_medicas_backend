<?php

namespace Database\Seeders;

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
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);

        Permission::create(['name' => 'ver pacientes']);
        Permission::create(['name' => 'crear pacientes']);
        Permission::create(['name' => 'editar pacientes']);
        Permission::create(['name' => 'eliminar pacientes']);

        Permission::create(['name' => 'ver expedientes']);
        Permission::create(['name' => 'editar expedientes']);
        Permission::create(['name' => 'ver citas']);
        Permission::create(['name' => 'crear citas']);
        Permission::create(['name' => 'editar citas']);
        Permission::create(['name' => 'eliminar citas']);
        Permission::create(['name' => 'ver horarios']);
        Permission::create(['name' => 'crear horarios']);
        Permission::create(['name' => 'editar horarios']);
        Permission::create(['name' => 'eliminar horarios']);
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'ver usuarios', 'crear usuarios', 'editar usuarios', 'eliminar usuarios'
        ]);
        $doctor = Role::create(['name' => 'doctor']);
        $doctor->givePermissionTo([
            'ver horarios',     
            'ver pacientes',   
            'ver expedientes',
            'editar expedientes', 
            'ver citas',          
        ]);
        $asistente = Role::create(['name' => 'asistente']);
        $asistente->givePermissionTo([
            'ver horarios', 'crear horarios', 'editar horarios', 'eliminar horarios', 
            'ver pacientes', 'crear pacientes', 'editar pacientes',                  
            'ver expedientes',                                                        
            'ver citas', 'crear citas', 'editar citas',                             
        ]);
    }
}
