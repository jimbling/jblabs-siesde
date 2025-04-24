<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $role = Role::firstOrCreate(['name' => 'super-admin']);

        $permissions = Permission::all();
        $role->syncPermissions($permissions);

        $user = User::find(2);
        if ($user) {
            $user->assignRole($role);
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
