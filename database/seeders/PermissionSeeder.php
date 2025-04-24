<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Membuat beberapa permission dasar
        Permission::firstOrCreate(['name' => 'atur akses']);
        Permission::firstOrCreate(['name' => 'atur lisensi']);
        Permission::firstOrCreate(['name' => 'atur sistem']);
        Permission::firstOrCreate(['name' => 'atur pemeliharaan']);
        Permission::firstOrCreate(['name' => 'atur pembaruan']);
        Permission::firstOrCreate(['name' => 'atur pengaturan']);
    }
}
