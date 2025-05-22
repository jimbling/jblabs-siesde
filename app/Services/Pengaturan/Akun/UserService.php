<?php

namespace App\Services\Pengaturan\Akun;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserService
{
    public function getProfileData(User $user)
    {
        return [
            'title' => 'Pengaturan Akun',
            'user' => $user,
        ];
    }

    public function updateProfile(User $user, array $validatedData)
    {
        $user->fill($validatedData);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
    }

    public function deleteAccount(User $user)
    {
        Auth::logout();
        $user->delete();

        session()->invalidate();
        session()->regenerateToken();
    }

    public function updateAvatar(User $user, $file)
    {
        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        $avatarPath = $file->store('avatars', 'public');
        $user->avatar = basename($avatarPath);
        $user->save();
    }

    public function deleteAvatar(User $user)
    {
        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        $user->avatar = null;
        $user->save();
    }
}
