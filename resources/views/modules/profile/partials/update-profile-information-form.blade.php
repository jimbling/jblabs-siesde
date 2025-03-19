<section>
    <header>
        <h2 class="h4 mb-2 text-dark">
            {{ __('Profile Information') }}
        </h2>

        <p class="text-muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <div class="row align-items-center mb-3">
        <div class="col-auto">
            <!-- Avatar Image -->
            <span class="avatar avatar-xl"
                style="background-image: url({{ asset('storage/avatars/' . ($user->avatar ?? 'default-avatar.png')) }})"></span>
        </div>
        <div class="col-auto">
            <!-- Button to open the modal -->
            <button type="button" class="btn btn-1" data-bs-toggle="modal" data-bs-target="#uploadAvatarModal">
                Ubah avatar
            </button>
        </div>
        <div class="col-auto">
            <!-- Button to delete avatar -->
            <a href="{{ route('profile.delete-avatar') }}" class="btn btn-ghost-danger btn-3">
                Hapus avatar
            </a>
        </div>
    </div>

    <!-- Modal for uploading avatar -->
    <div class="modal fade" id="uploadAvatarModal" tabindex="-1" aria-labelledby="uploadAvatarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadAvatarModalLabel">Unggah Avatar Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for uploading avatar -->
                    <form method="POST" action="{{ route('profile.update-avatar') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Pilih Avatar</label>
                            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*"
                                required>
                            @error('avatar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Unggah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')



        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control"
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-muted">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn btn-link p-0">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success mt-2">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-start align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-muted">
                    {{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
