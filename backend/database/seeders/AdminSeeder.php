<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            [
                'email' => 'admin@meilleurepharma.ma',
            ],
            [
                'name' => 'Administrateur',
                'password' => bcrypt('password'),
            ]
        );

        $admin->assignRole('Administrateur');
    }
}