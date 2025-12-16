@extends('admin.layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="page-header">
    <div>
        <h1>Profil Saya</h1>
        <p>Kelola informasi akun dan keamanan</p>
    </div>
</div>

<div class="form-grid">
    <!-- Left Column: Profile Info -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informasi Akun</h3>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <!-- Avatar -->
                <div class="form-group" style="text-align: center; margin-bottom: 24px;">
                    <div style="width: 100px; height: 100px; margin: 0 auto 16px; position: relative;">
                        <img id="avatarPreview" src="{{ auth()->user()->avatar_url }}"
                             alt="{{ auth()->user()->name }}"
                             style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 3px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">

                        <label for="avatar" style="position: absolute; bottom: 0; right: 0; background: var(--color-primary-500); color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: transform 0.2s; border: 2px solid white;">
                            <i data-feather="camera" style="width: 16px; height: 16px;"></i>
                        </label>
                        <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;" onchange="previewAvatar(this)">
                    </div>
                    <p style="font-size: 13px; color: var(--color-gray-500); margin: 0;">Klik ikon kamera untuk ganti foto</p>
                </div>

                <div class="form-group">
                    <label class="form-label required" for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-input @error('name') error @enderror"
                           value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label required" for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" class="form-input @error('email') error @enderror"
                           value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="card-footer" style="text-align: right;">
                <button type="submit" class="btn btn-primary">
                    <i data-feather="save"></i>
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>

    <!-- Right Column: Security -->
    <div class="card" style="height: fit-content;">
        <div class="card-header">
            <h3 class="card-title">Ganti Password</h3>
        </div>

        <form action="{{ route('admin.profile.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label class="form-label required" for="current_password">Password Saat Ini</label>
                    <input type="password" id="current_password" name="current_password"
                           class="form-input @error('current_password') error @enderror" required>
                    @error('current_password')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label required" for="password">Password Baru</label>
                    <input type="password" id="password" name="password"
                           class="form-input @error('password') error @enderror" required>
                    @error('password')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label required" for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="form-input" required>
                </div>
            </div>

            <div class="card-footer" style="text-align: right;">
                <button type="submit" class="btn btn-warning" style="background: var(--color-warning); border-color: var(--color-warning); color: white;">
                    <i data-feather="lock"></i>
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
