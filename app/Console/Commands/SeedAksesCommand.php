<?php

// app/Console/Commands/SeedAksesCommand.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\SuperAdminSeeder;

class SeedAksesCommand extends Command
{
    protected $signature = 'seed:akses';
    protected $description = 'Menjalankan PermissionSeeder dan SuperAdminSeeder saja.';

    public function handle(): int
    {
        $this->info('Menjalankan PermissionSeeder...');
        $this->call(PermissionSeeder::class);

        $this->info('Menjalankan SuperAdminSeeder...');
        $this->call(SuperAdminSeeder::class);

        $this->info('✅ Selesai! Permissions & Super Admin sudah diset.');
        return Command::SUCCESS;
    }
}
