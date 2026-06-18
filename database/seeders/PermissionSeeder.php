<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            'ver parasitos',
            'crear parasitos',
            'editar parasitos',
            'eliminar parasitos',

            'ver mapas',
            'crear mapas',
            'editar mapas',
            'eliminar mapas',

            'ver partes',
            'crear partes',
            'editar partes',
            'eliminar partes',

            'ver quiz',
            'crear quiz',
            'editar quiz',
            'eliminar quiz',

            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',

            'ver roles',
            'crear roles',
            'editar roles',
            'eliminar roles',

            'ver asistente ia'

        ];

        foreach ($permissions as $permission)
        {
            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }
    }
}