<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin sipat',
                'email' => 'admin@sipat.test',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ],
            [
                'name' => 'petugas sipat',
                'email' => 'petugas@sipat.test',
                'password' => Hash::make('password'),
                'role' => 'petugas'
            ],
            [
                'name' => 'budi',
                'email' => 'budi111@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'peminjam'

            ]
        ];
        foreach ($users as $user) {
            User::create($user);
        };
    }
}
