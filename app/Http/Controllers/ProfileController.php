<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Helpers\BreadcrumbHelper;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('modules.profile.edit', [
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
}
