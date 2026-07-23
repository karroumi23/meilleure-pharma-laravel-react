<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'Administrateur',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'Pharmacien',
            'guard_name' => 'web',
        ]);
    }
}