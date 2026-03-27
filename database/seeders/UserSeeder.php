<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@panederiagrace.com'],
            [
                'name'     => 'Administrador',
                'email'    => 'admin@panederiagrace.com',
                'password' => Hash::make('admin1234'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'grace@panederiagrace.com'],
            [
                'name'     => 'Grace',
                'email'    => 'grace@panederiagrace.com',
                'password' => Hash::make('grace1234'),
            ]
        );
    }
}
