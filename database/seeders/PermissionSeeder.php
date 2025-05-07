<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Format: [name, group]
            ['lihat hak akses', 'Administrator'],
            ['lihat sistem', 'Administrator'],
            ['lihat pemeliharaan', 'Administrator'],
            ['lihat pembaruan', 'Administrator'],
            ['edit hak akses', 'Administrator'],
            ['update hak akses', 'Administrator'],
            ['update peran', 'Administrator'],
            ['reset password', 'Administrator'],
            ['hapus akun', 'Administrator'],
            ['lihat siswa', 'Buku Induk'],
            ['edit siswa', 'Buku Induk'],
            ['tambah siswa', 'Buku Induk'],
            ['hapus siswa', 'Buku Induk'],
            ['atur rombel', 'Buku Induk'],
            ['atur tahun ajaran', 'Buku Induk'],
            ['atur semester', 'Buku Induk'],
            ['atur kenaikan', 'Buku Induk'],
            ['atur foto', 'Buku Induk'],





            // GUNAKAN PERINTAH php artisan seed:akses UNTUK MENJALANKAN SEEDER INI
        ];

        foreach ($permissions as [$name, $group]) {
            Permission::firstOrCreate(
                ['name' => $name],
                ['guard_name' => 'web', 'group' => $group]
            );
        }


        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
