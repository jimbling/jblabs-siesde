<?php

namespace App\Services\Pengaturan\Akses;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class AksesService
{
    public function getAksesData()
    {
        return [
            'users' => User::all(),
            'totalUsers' => User::count(),
            'roles' => Role::where('name', '!=', 'super-admin')->get(),
        ];
    }

    public function getEditPermissionData($roleId = null)
    {
        $roles = Role::where('name', '!=', 'super-admin')->get();
        $permissions = Permission::all()->groupBy('group');

        $selectedRole = null;
        if ($roleId) {
            $selectedRole = Role::where('name', '!=', 'super-admin')->find($roleId);
        }

        return compact('roles', 'permissions', 'selectedRole');
    }

    public function updatePermissions($roleId, array $permissions)
    {
        $selectedRole = Role::findOrFail($roleId);

        if ($selectedRole->name === 'super-admin') {
            throw new \Exception('Perubahan pada role Super Admin tidak diizinkan.');
        }

        $selectedRole->permissions()->sync($permissions ?? []);
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    public function updateRole(User $user, $role)
    {
        if (!Role::where('name', $role)->exists()) {
            throw new \Exception('Role tidak ditemukan.');
        }

        $user->syncRoles([$role]);
    }

    public function resetPassword(User $user)
    {
        $user->password = bcrypt('defaultpassword');
        $user->save();
    }

    public function deleteAccounts(array $userIds)
    {
        User::whereIn('id', $userIds)->delete();
    }
}
