<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@pialoatech.com'],
            [
                'name' => 'Administrateur',
                'password' => 'ChangeMoi123!', // hashé automatiquement via le cast 'hashed'
                'role' => 'admin',
            ]
        );
    }
}
