<?php

namespace App\Http\Controllers\Modules\Pengaturan;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Helpers\BreadcrumbHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;


class PengaturanController extends Controller
{
    public function index()
    {
        return view('modules.admin.pengaturan', [
            'title' => 'Pengaturan',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Pengaturan']
            ]),
            'user' => Auth::user(),
        ]);
    }

    public function lisensi()
    {
        return view('modules.admin.lisensi', [
            'title' => 'Lisensi',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Pengaturan', 'url' => route('pengaturan.index')],
                ['name' => 'Lisensi']
            ])
        ]);
    }

    public function edit(Request $request): View
    {
        return view('modules.admin.pengaturan', [
            'title' => 'Edit Profile',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Profile', 'url' => route('profile.edit')],
                ['name' => 'Edit Profile'],
            ]),
            'user' => $request->user(),
        ]);
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            $request->user()->fill($request->validated());

            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }

            $request->user()->save();

            // Mengirimkan session success

            return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            // Mengirimkan session error
            return Redirect::route('profile.edit')->with('error', 'Terjadi kesalahan saat memperbarui profil.');
        }
    }



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateAvatar(Request $request)
    {
        $user = $request->user();

        // Validasi file avatar
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1048',
        ]);

        // Hapus avatar lama jika ada
        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        // Upload avatar baru
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = basename($avatarPath);
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Avatar berhasil diupdate.');
    }

    // Method untuk menghapus avatar
    public function deleteAvatar(Request $request)
    {
        $user = $request->user();

        // Pastikan ada file avatar yang terkait
        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            // Hapus file avatar dari storage
            Storage::delete('public/avatars/' . $user->avatar);
        }

        // Set avatar di database menjadi null
        $user->avatar = null;
        $user->save();

        return redirect()->back()->with('success', 'Avatar berhasil dihapus');
    }
}
