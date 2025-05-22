<?php

namespace App\Http\Controllers\Modules\Pengaturan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\Pengaturan\Akses\AksesService;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Helpers\BreadcrumbHelper;

class AksesController extends Controller
{
    protected $aksesService;

    public function __construct(AksesService $aksesService)
    {
        $this->aksesService = $aksesService;
    }

    public function akses()
    {
        $aksesData = $this->aksesService->getAksesData();

        return view('modules.admin.pengaturan-akses', array_merge([
            'title' => 'Pengaturan Akses',
            'breadcrumbs' => BreadcrumbHelper::generate([['name' => 'Pengaturan Akses']]),
            'user' => Auth::user(),
        ], $aksesData));
    }

    public function editPermission(Request $request)
    {
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $editData = $this->aksesService->getEditPermissionData($request->role_id ?? null);

        return view('modules.admin.partials.edit-hak-akses', array_merge([
            'title' => 'Edit Hak Akses',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Pengaturan Akses', 'url' => route('pengaturan.akses')],
                ['name' => 'Edit Hak Akses']
            ]),
        ], $editData));
    }

    public function updatePermission(Request $request)
    {
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

        try {
            $this->aksesService->updatePermissions($request->role_id, $request->permissions ?? []);

            return redirect()
                ->route('pengaturan.akses.edit-permission', ['role_id' => $request->role_id])
                ->with('success', 'Perubahan hak akses berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateRole(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        try {
            $this->aksesService->updateRole($user, $request->role);
            return back()->with('success', 'Peran berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function editRole($id)
    {
        $user = User::findOrFail($id);
        return view('modules.admin.edit-role', compact('user'));
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->aksesService->resetPassword($user);

        return back()->with('success', 'Password berhasil direset!');
    }

    public function hapusAkun(Request $request)
    {
        $ids = $request->input('user_ids', []);

        try {
            $this->aksesService->deleteAccounts($ids);
            return redirect()->back()->with('success', 'Akun berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
