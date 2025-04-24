<?php

namespace App\Http\Controllers\Modules\Pengaturan;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\BreadcrumbHelper;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class AksesController extends Controller
{
    public function akses()
    {
        return view('modules.admin.pengaturan-akses', [
            'title' => 'Pengaturan Akses',
            'breadcrumbs' => BreadcrumbHelper::generate([['name' => 'Pengaturan Akses']]),
            'user' => Auth::user(),
            'users' => User::all(),
            'totalUsers' => User::count(),  // Menambahkan jumlah total pengguna
            'roles' => Role::where('name', '!=', 'super-admin')->get(), // <-- Memfilter role yang bukan super-admin
        ]);
    }


    public function editPermission(Request $request)
    {
        // Pastikan hanya Super Admin yang dapat mengakses halaman ini
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Exclude super-admin dari daftar role yang bisa diedit
        $roles = Role::where('name', '!=', 'super-admin')->get();
        $permissions = Permission::all()->groupBy('group');

        // Ambil role yang dipilih berdasarkan request
        $selectedRole = null;
        if ($request->has('role_id')) {
            $selectedRole = Role::where('name', '!=', 'super-admin')
                ->find($request->role_id);
        }

        return view('modules.admin.partials.edit-hak-akses', [
            'title' => 'Edit Hak Akses',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Pengaturan Akses', 'url' => route('pengaturan.akses')],
                ['name' => 'Edit Hak Akses']
            ]),
            'roles' => $roles,
            'permissions' => $permissions,
            'selectedRole' => $selectedRole
        ]);
    }



    public function updatePermission(Request $request)
    {
        // Pastikan hanya Super Admin yang dapat mengupdate hak akses
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'role_id.required' => 'Pilih role yang ingin diatur.',
            'permissions.*.exists' => 'Hak akses yang dipilih tidak valid.',
        ]);

        $selectedRole = Role::findOrFail($request->role_id);

        // Cegah update permission untuk role super-admin
        if ($selectedRole->name === 'super-admin') {
            return redirect()
                ->back()
                ->with('error', 'Perubahan pada role Super Admin tidak diizinkan.');
        }

        $selectedRole->permissions()->sync($request->permissions ?? []);

        return redirect()
            ->route('pengaturan.akses.edit-permission', ['role_id' => $selectedRole->id])
            ->with('success', 'Perubahan hak akses berhasil disimpan!');
    }





    public function updateRole(Request $request)
    {
        // Temukan user berdasarkan ID
        $user = User::findOrFail($request->user_id);

        // Pastikan role yang dipilih ada di dalam daftar role yang tersedia
        if (Role::where('name', $request->role)->exists()) {
            // Sinkronkan role user dengan role baru
            $user->syncRoles([$request->role]);
            return back()->with('success', 'Peran berhasil diperbarui.');
        } else {
            return back()->with('error', 'Role tidak ditemukan.');
        }
    }


    public function editRole($id)
    {
        $user = User::findOrFail($id);
        // tampilkan form untuk ubah peran
        return view('modules.admin.edit-role', compact('user'));
    }



    public function resetPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->password = bcrypt('defaultpassword'); // atau generate password acak
        $user->save();

        return back()->with('success', 'Password berhasil direset!');
    }

    public function hapusAkun(Request $request)
    {
        $ids = $request->input('user_ids', []);

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada pengguna yang dipilih.');
        }

        User::whereIn('id', $ids)->delete();

        return back()->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
