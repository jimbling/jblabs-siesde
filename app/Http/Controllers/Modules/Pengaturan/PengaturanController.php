<?php

namespace App\Http\Controllers\Modules\Pengaturan;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Services\Pengaturan\Akun\UserService;
use App\Helpers\BreadcrumbHelper;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;

class PengaturanController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('modules.admin.pengaturan', array_merge([
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Pengaturan Akun']
            ]),
        ], $this->userService->getProfileData(Auth::user())));
    }

    public function lisensi()
    {
        return view('modules.admin.lisensi', [
            'title' => 'Lisensi',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Lisensi']
            ])
        ]);
    }

    public function edit(Request $request): View
    {
        return view('modules.admin.pengaturan', array_merge([
            'title' => 'Edit Profile',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Profile', 'url' => route('profile.edit')],
                ['name' => 'Edit Profile'],
            ]),
        ], $this->userService->getProfileData($request->user())));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            $this->userService->updateProfile($request->user(), $request->validated());

            return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')->with('error', 'Terjadi kesalahan saat memperbarui profil.');
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $this->userService->deleteAccount($request->user());

        return Redirect::to('/');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1048',
        ]);

        $this->userService->updateAvatar($request->user(), $request->file('avatar'));

        return redirect()->route('profile.edit')->with('success', 'Avatar berhasil diupdate.');
    }

    public function deleteAvatar(Request $request)
    {
        $this->userService->deleteAvatar($request->user());

        return redirect()->back()->with('success', 'Avatar berhasil dihapus');
    }
}
