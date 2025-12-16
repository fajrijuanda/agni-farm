@extends('admin.layouts.app')

@section('title', isset($category) ? 'Edit Kategori' : 'Tambah Kategori')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.categories.index') }}">Kategori</a>
    <span>/</span>
    <span>{{ isset($category) ? 'Edit' : 'Tambah' }}</span>
@endsection

@section('content')
<div class="page-header">
    <h1>{{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori' }}</h1>
    <p>{{ isset($category) ? 'Perbarui informasi kategori' : 'Buat kategori baru untuk produk Anda' }}</p>
</div>

<div style="max-width: 600px;">
    <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @if(isset($category))
            @method('PUT')
        @endif

        <div class="card">
            <div class="card-body">
                <!-- Nama -->
                <div class="form-group">
                    <label class="form-label required" for="name">Nama Kategori</label>
                    <input type="text"
                           id="name"
                           name="name"
                           class="form-input @error('name') error @enderror"
                           value="{{ old('name', $category->name ?? '') }}"
                           placeholder="Contoh: Bibit Tanaman"
                           required>
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description"
                              name="description"
                              class="form-textarea @error('description') error @enderror"
                              placeholder="Deskripsi singkat tentang kategori ini..."
                              rows="3">{{ old('description', $category->description ?? '') }}</textarea>
                    @error('description')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Icon (Emoji) -->
                <div class="form-group">
                    <label class="form-label" for="icon">Icon (Emoji)</label>
                    <input type="text"
                           id="icon"
                           name="icon"
                           class="form-input @error('icon') error @enderror"
                           value="{{ old('icon', $category->icon ?? '') }}"
                           placeholder="🌱"
                           style="width: 100px; text-align: center; font-size: 24px;">
                    <div class="form-hint">Masukkan emoji sebagai icon kategori</div>
                    @error('icon')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div class="form-group">
                    <label class="form-label" for="image">Gambar Kategori</label>

                    @if(isset($category) && $category->image)
                        <div style="margin-bottom: 12px;">
                            <img src="{{ asset('storage/' . $category->image) }}"
                                 alt="{{ $category->name }}"
                                 style="max-width: 200px; border-radius: 12px;">
                            <p style="font-size: 13px; color: var(--color-gray-500); margin-top: 8px;">
                                Gambar saat ini. Upload gambar baru untuk mengganti.
                            </p>
                        </div>
                    @endif

                    <div class="file-upload-area" id="imageDropZone" style="border: 2px dashed var(--color-gray-300); border-radius: 12px; padding: 32px; text-align: center; cursor: pointer; transition: all 0.2s ease;">
                        <i data-feather="upload" style="width: 32px; height: 32px; color: var(--color-gray-400); margin-bottom: 8px;"></i>
                        <p style="color: var(--color-gray-600); margin: 0;">Drag & drop gambar atau klik untuk upload</p>
                        <p style="font-size: 12px; color: var(--color-gray-400); margin-top: 4px;">PNG, JPG, WEBP (max 2MB)</p>
                        <input type="file"
                               id="image"
                               name="image"
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               style="display: none;">
                    </div>
                    <div id="imagePreview" style="margin-top: 12px; display: none;">
                        <img id="previewImg" src="" alt="Preview" style="max-width: 200px; border-radius: 12px;">
                        <button type="button" onclick="removeImage()" class="btn btn-sm btn-ghost" style="margin-left: 8px;">
                            <i data-feather="x"></i>
                            Hapus
                        </button>
                    </div>
                    @error('image')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Toggle -->
                <div class="form-group">
                    <label class="form-toggle">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                        <span class="toggle-switch"></span>
                        <span>Kategori Aktif</span>
                    </label>
                    <div class="form-hint">Kategori yang nonaktif tidak akan ditampilkan di website</div>
                </div>
            </div>

            <div class="card-footer" style="display: flex; justify-content: space-between;">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    <i data-feather="arrow-left"></i>
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i data-feather="save"></i>
                    {{ isset($category) ? 'Simpan Perubahan' : 'Simpan Kategori' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
const dropZone = document.getElementById('imageDropZone');
const fileInput = document.getElementById('image');
const previewContainer = document.getElementById('imagePreview');
const previewImg = document.getElementById('previewImg');

// Click to upload
dropZone.addEventListener('click', () => fileInput.click());

// Drag & Drop
dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.style.borderColor = 'var(--color-primary-500)';
    dropZone.style.background = 'var(--color-primary-50)';
});

dropZone.addEventListener('dragleave', () => {
    dropZone.style.borderColor = 'var(--color-gray-300)';
    dropZone.style.background = 'transparent';
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.style.borderColor = 'var(--color-gray-300)';
    dropZone.style.background = 'transparent';

    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        showPreview(e.dataTransfer.files[0]);
    }
});

fileInput.addEventListener('change', (e) => {
    if (e.target.files.length) {
        showPreview(e.target.files[0]);
    }
});

function showPreview(file) {
    if (!file.type.startsWith('image/')) {
        toast.error('Error', 'File harus berupa gambar');
        return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
        previewImg.src = e.target.result;
        previewContainer.style.display = 'flex';
        previewContainer.style.alignItems = 'center';
        dropZone.style.display = 'none';
    };
    reader.readAsDataURL(file);
}

function removeImage() {
    fileInput.value = '';
    previewContainer.style.display = 'none';
    dropZone.style.display = 'block';
}
</script>
@endpush
