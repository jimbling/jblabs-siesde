@extends('layouts.tabler')

@section('title', $title ?? 'Dashboard')

@section('page-title', 'Welcome to the Dashboard')

@section('content')
    <div class="container-xl">
        <form action="{{ route('pengaturan.akses.edit-permission') }}" method="GET">
            @csrf
            <div class="mb-3">
                <label for="role" class="form-label">Pilih Role</label>
                <select name="role_id" id="role_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ isset($selectedRole) && $selectedRole->id == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        @if (isset($selectedRole))
            <form action="{{ route('pengaturan.akses.update-permissions') }}" method="POST">
                @csrf
                <input type="hidden" name="role_id" value="{{ $selectedRole->id }}">

                <div class="row">
                    @foreach ($permissions as $groupName => $groupPermissions)
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">{{ ucfirst($groupName ?? 'Lainnya') }}</h3>
                                </div>
                                <div class="card-body">
                                    @foreach ($groupPermissions as $permission)
                                        <div class="mb-2">
                                            <label class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                                    value="{{ $permission->id }}"
                                                    {{ $selectedRole->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                <span class="form-check-label">{{ $permission->name }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('pengaturan.akses') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        @endif
    </div>

@endsection
