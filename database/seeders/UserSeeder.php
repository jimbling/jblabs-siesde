<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role 'user' jika belum ada
        $role = Role::firstOrCreate(['name' => 'user']);

        // Buat 50 user dummy dan assign role 'user'
        \App\Models\User::factory(50)->create()->each(function ($user) use ($role) {
            $user->assignRole($role);
        });
    }
}
