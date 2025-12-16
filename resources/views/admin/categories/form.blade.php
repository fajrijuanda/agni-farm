@extends('admin.layouts.app')

@section('title', isset($category) ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
<div class="page-header">
    <div>
        <h1>{{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori' }}</h1>
        <p>{{ isset($category) ? 'Perbarui informasi kategori' : 'Buat kategori baru untuk produk Anda' }}</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i data-feather="arrow-left"></i> Kembali
    </a>
</div>

<form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($category)) @method('PUT') @endif

    <div class="form-grid">
        <!-- Left Column: Main Info -->
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label required" for="name">Nama Kategori</label>
                    <input type="text" id="name" name="name" class="form-input @error('name') error @enderror"
                           value="{{ old('name', $category->name ?? '') }}" placeholder="Contoh: Bibit Tanaman" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description" class="form-textarea @error('description') error @enderror"
                              rows="4" placeholder="Deskripsi singkat tentang kategori ini...">{{ old('description', $category->description ?? '') }}</textarea>
                    @error('description')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

             <div class="card-footer" style="text-align: right;">
                <button type="submit" class="btn btn-primary">
                    <i data-feather="save"></i>
                    {{ isset($category) ? 'Simpan Perubahan' : 'Buat Kategori' }}
                </button>
            </div>
        </div>

        <!-- Right Column: Sidebar -->
        <div class="card">
            <div class="card-body">
                <!-- Status -->
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <label class="form-toggle">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                        <span class="toggle-switch"></span>
                        <span style="font-weight: 500; font-size: 14px;">Aktif</span>
                    </label>
                    <div class="form-hint">Nonaktifkan untuk menyembunyikan kategori ini</div>
                </div>

                <hr style="border: 0; border-top: 1px solid var(--color-gray-100); margin: 24px 0;">

                <!-- Icon -->
                <div class="form-group">
                    <label class="form-label" for="icon">Icon (Emoji)</label>
                    <input type="text" id="icon" name="icon" class="emoji-input @error('icon') error @enderror"
                           value="{{ old('icon', $category->icon ?? '') }}" placeholder="🌱">
                    <div class="form-hint" style="text-align: center;">Pilih satu emoji sebagai icon</div>
                    @error('icon')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <hr style="border: 0; border-top: 1px solid var(--color-gray-100); margin: 24px 0;">

                <!-- Image -->
                <div class="form-group">
                    <label class="form-label">Gambar Kategori</label>

                    <input type="file" id="image" name="image" accept="image/*" style="display: none;" onchange="previewImage(this)">

                    <div class="file-upload-area" onclick="document.getElementById('image').click()">
                        @if(isset($category) && $category->image)
                            <img id="preview" src="{{ asset('storage/' . $category->image) }}" style="max-width: 100%; border-radius: 8px; margin-bottom: 8px;">
                            <div id="upload-placeholder" style="display: none;">
                                <i data-feather="image" class="file-upload-icon"></i>
                                <p style="font-size: 13px; color: var(--color-gray-500); margin: 0;">Klik untuk ganti gambar</p>
                            </div>
                        @else
                            <img id="preview" src="" style="max-width: 100%; border-radius: 8px; margin-bottom: 8px; display: none;">
                            <div id="upload-placeholder">
                                <i data-feather="image" class="file-upload-icon"></i>
                                <p style="font-size: 13px; color: var(--color-gray-500); margin: 0;">Klik untuk upload gambar</p>
                            </div>
                        @endif
                    </div>
                     @error('image')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview');
                preview.src = e.target.result;
                preview.style.display = 'block';

                const placeholder = document.getElementById('upload-placeholder');
                if (placeholder) placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
