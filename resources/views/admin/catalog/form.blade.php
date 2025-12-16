@extends('admin.layouts.app')

@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.catalog.index') }}">Catalog</a>
    <span>/</span>
    <span>{{ isset($product) ? 'Edit' : 'Tambah' }}</span>
@endsection

@section('content')
<div class="page-header">
    <h1>{{ isset($product) ? 'Edit Produk' : 'Tambah Produk' }}</h1>
    <p>{{ isset($product) ? 'Perbarui informasi produk' : 'Tambahkan produk baru ke catalog' }}</p>
</div>

<form action="{{ isset($product) ? route('admin.catalog.update', $product) : route('admin.catalog.store') }}"
      method="POST"
      enctype="multipart/form-data"
      id="productForm">
    @csrf
    @if(isset($product))
        @method('PUT')
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <!-- Main Content -->
        <div>
            <!-- Basic Info -->
            <div class="card" style="margin-bottom: 24px;">
                <div class="card-header">
                    <h3 class="card-title">Informasi Produk</h3>
                </div>
                <div class="card-body">
                    <!-- Nama -->
                    <div class="form-group">
                        <label class="form-label required" for="name">Nama Produk</label>
                        <input type="text"
                               id="name"
                               name="name"
                               class="form-input @error('name') error @enderror"
                               value="{{ old('name', $product->name ?? '') }}"
                               placeholder="Contoh: Bibit Tomat Cherry Premium"
                               required>
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div class="form-group">
                        <label class="form-label required" for="category_id">Kategori</label>
                        <select id="category_id"
                                name="category_id"
                                class="form-select @error('category_id') error @enderror"
                                required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Short Description -->
                    <div class="form-group">
                        <label class="form-label" for="short_description">Deskripsi Singkat</label>
                        <textarea id="short_description"
                                  name="short_description"
                                  class="form-textarea @error('short_description') error @enderror"
                                  placeholder="Deskripsi singkat untuk card produk (max 300 karakter)"
                                  rows="2"
                                  maxlength="300">{{ old('short_description', $product->short_description ?? '') }}</textarea>
                        <div class="form-hint">
                            <span id="shortDescCount">0</span>/300 karakter
                        </div>
                        @error('short_description')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Full Description -->
                    <div class="form-group">
                        <label class="form-label" for="full_description">Deskripsi Lengkap</label>
                        <textarea id="full_description"
                                  name="full_description"
                                  class="form-textarea @error('full_description') error @enderror"
                                  placeholder="Deskripsi detail produk..."
                                  rows="6">{{ old('full_description', $product->full_description ?? '') }}</textarea>
                        @error('full_description')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Images -->
            <div class="card" style="margin-bottom: 24px;">
                <div class="card-header">
                    <h3 class="card-title">Foto Produk</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        @if(isset($product) && $product->images->count() > 0)
                            <label class="form-label">Foto Saat Ini</label>
                            <div id="existingImages" style="display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
                                @foreach($product->images as $image)
                                    <div class="existing-image-item" data-id="{{ $image->id }}" style="position: relative;">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             alt="Product Image"
                                             style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 2px solid {{ $image->is_primary ? 'var(--color-primary-500)' : 'transparent' }};">
                                        <input type="hidden" name="existing_images[]" value="{{ $image->id }}">
                                        @if($image->is_primary)
                                            <span style="position: absolute; top: 4px; left: 4px; background: var(--color-primary-500); color: white; font-size: 10px; padding: 2px 6px; border-radius: 4px;">
                                                Utama
                                            </span>
                                        @endif
                                        <button type="button"
                                                onclick="removeExistingImage(this, {{ $image->id }})"
                                                style="position: absolute; top: -8px; right: -8px; width: 24px; height: 24px; border-radius: 50%; background: var(--color-error); color: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                            <i data-feather="x" style="width: 14px; height: 14px;"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <label class="form-label {{ isset($product) ? '' : 'required' }}">
                            {{ isset($product) ? 'Tambah Foto Baru' : 'Upload Foto' }}
                        </label>
                        <div id="imageDropZone" style="border: 2px dashed var(--color-gray-300); border-radius: 12px; padding: 32px; text-align: center; cursor: pointer; transition: all 0.2s ease;">
                            <i data-feather="upload-cloud" style="width: 40px; height: 40px; color: var(--color-gray-400); margin-bottom: 8px;"></i>
                            <p style="color: var(--color-gray-600); margin: 0;">Drag & drop foto atau klik untuk upload</p>
                            <p style="font-size: 12px; color: var(--color-gray-400); margin-top: 4px;">PNG, JPG, WEBP (max 2MB per file)</p>
                            <input type="file"
                                   id="images"
                                   name="images[]"
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   multiple
                                   style="display: none;"
                                   {{ isset($product) ? '' : 'required' }}>
                        </div>
                        <div id="imagePreviewContainer" style="display: flex; flex-wrap: wrap; gap: 12px; margin-top: 16px;"></div>
                        @error('images')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Specifications -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Spesifikasi</h3>
                </div>
                <div class="card-body">
                    <div id="specificationsContainer">
                        @if(isset($product) && $product->specifications->count() > 0)
                            @foreach($product->specifications as $index => $spec)
                                <div class="spec-row" style="display: flex; gap: 12px; margin-bottom: 12px;">
                                    <input type="text"
                                           name="specifications[{{ $index }}][key]"
                                           class="form-input"
                                           placeholder="Nama (cth: Berat)"
                                           value="{{ $spec->key }}"
                                           style="flex: 1;">
                                    <input type="text"
                                           name="specifications[{{ $index }}][value]"
                                           class="form-input"
                                           placeholder="Nilai (cth: 500gr)"
                                           value="{{ $spec->value }}"
                                           style="flex: 1;">
                                    <button type="button" class="btn btn-ghost" onclick="removeSpec(this)">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="spec-row" style="display: flex; gap: 12px; margin-bottom: 12px;">
                                <input type="text"
                                       name="specifications[0][key]"
                                       class="form-input"
                                       placeholder="Nama (cth: Berat)"
                                       style="flex: 1;">
                                <input type="text"
                                       name="specifications[0][value]"
                                       class="form-input"
                                       placeholder="Nilai (cth: 500gr)"
                                       style="flex: 1;">
                                <button type="button" class="btn btn-ghost" onclick="removeSpec(this)">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="addSpec()">
                        <i data-feather="plus"></i>
                        Tambah Spesifikasi
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Pricing -->
            <div class="card" style="margin-bottom: 24px;">
                <div class="card-header">
                    <h3 class="card-title">Harga</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label required" for="price">Harga Normal</label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--color-gray-500);">Rp</span>
                            <input type="number"
                                   id="price"
                                   name="price"
                                   class="form-input @error('price') error @enderror"
                                   value="{{ old('price', $product->price ?? '') }}"
                                   placeholder="0"
                                   min="0"
                                   step="1000"
                                   style="padding-left: 40px;"
                                   required>
                        </div>
                        @error('price')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="discount_price">Harga Diskon</label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--color-gray-500);">Rp</span>
                            <input type="number"
                                   id="discount_price"
                                   name="discount_price"
                                   class="form-input @error('discount_price') error @enderror"
                                   value="{{ old('discount_price', $product->discount_price ?? '') }}"
                                   placeholder="Kosongkan jika tidak ada diskon"
                                   min="0"
                                   step="1000"
                                   style="padding-left: 40px;">
                        </div>
                        <div class="form-hint">Kosongkan jika tidak ada promo</div>
                        @error('discount_price')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Shopee Link -->
            <div class="card" style="margin-bottom: 24px;">
                <div class="card-header">
                    <h3 class="card-title">Link Shopee</h3>
                </div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label required" for="shopee_link">URL Produk di Shopee</label>
                        <input type="url"
                               id="shopee_link"
                               name="shopee_link"
                               class="form-input @error('shopee_link') error @enderror"
                               value="{{ old('shopee_link', $product->shopee_link ?? '') }}"
                               placeholder="https://shopee.co.id/..."
                               required>
                        <div class="form-hint">Link ini akan digunakan untuk tombol "Beli di Shopee"</div>
                        @error('shopee_link')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="card" style="margin-bottom: 24px;">
                <div class="card-header">
                    <h3 class="card-title">Status</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-toggle">
                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                            <span class="toggle-switch"></span>
                            <span>Produk Aktif</span>
                        </label>
                        <div class="form-hint">Produk nonaktif tidak ditampilkan di website</div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-toggle">
                            <input type="checkbox"
                                   name="is_featured"
                                   value="1"
                                   {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                            <span class="toggle-switch"></span>
                            <span>Produk Featured</span>
                        </label>
                        <div class="form-hint">Tampilkan di homepage</div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 12px;">
                        <i data-feather="save"></i>
                        {{ isset($product) ? 'Simpan Perubahan' : 'Simpan Produk' }}
                    </button>
                    <a href="{{ route('admin.catalog.index') }}" class="btn btn-secondary" style="width: 100%;">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
// Character counter
const shortDesc = document.getElementById('short_description');
const shortDescCount = document.getElementById('shortDescCount');

function updateCount() {
    shortDescCount.textContent = shortDesc.value.length;
}
shortDesc.addEventListener('input', updateCount);
updateCount();

// Image Upload
const dropZone = document.getElementById('imageDropZone');
const fileInput = document.getElementById('images');
const previewContainer = document.getElementById('imagePreviewContainer');
let selectedFiles = [];

dropZone.addEventListener('click', () => fileInput.click());

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
    handleFiles(e.dataTransfer.files);
});

fileInput.addEventListener('change', (e) => {
    handleFiles(e.target.files);
});

function handleFiles(files) {
    for (const file of files) {
        if (!file.type.startsWith('image/')) continue;
        if (file.size > 2 * 1024 * 1024) {
            toast.error('Error', `${file.name} melebihi 2MB`);
            continue;
        }

        selectedFiles.push(file);
        showPreview(file, selectedFiles.length - 1);
    }
    updateFileInput();
}

function showPreview(file, index) {
    const reader = new FileReader();
    reader.onload = (e) => {
        const div = document.createElement('div');
        div.className = 'preview-item';
        div.style.cssText = 'position: relative;';
        div.innerHTML = `
            <img src="${e.target.result}"
                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
            <button type="button"
                    onclick="removePreview(${index})"
                    style="position: absolute; top: -8px; right: -8px; width: 24px; height: 24px; border-radius: 50%; background: var(--color-error); color: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                <i data-feather="x" style="width: 14px; height: 14px;"></i>
            </button>
        `;
        previewContainer.appendChild(div);
        feather.replace();
    };
    reader.readAsDataURL(file);
}

function removePreview(index) {
    selectedFiles.splice(index, 1);
    previewContainer.innerHTML = '';
    selectedFiles.forEach((file, i) => showPreview(file, i));
    updateFileInput();
}

function updateFileInput() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    fileInput.files = dt.files;
}

function removeExistingImage(btn, id) {
    const item = btn.closest('.existing-image-item');
    item.remove();
}

// Specifications
let specIndex = {{ isset($product) ? $product->specifications->count() : 1 }};

function addSpec() {
    const container = document.getElementById('specificationsContainer');
    const row = document.createElement('div');
    row.className = 'spec-row';
    row.style.cssText = 'display: flex; gap: 12px; margin-bottom: 12px;';
    row.innerHTML = `
        <input type="text"
               name="specifications[${specIndex}][key]"
               class="form-input"
               placeholder="Nama (cth: Berat)"
               style="flex: 1;">
        <input type="text"
               name="specifications[${specIndex}][value]"
               class="form-input"
               placeholder="Nilai (cth: 500gr)"
               style="flex: 1;">
        <button type="button" class="btn btn-ghost" onclick="removeSpec(this)">
            <i data-feather="trash-2"></i>
        </button>
    `;
    container.appendChild(row);
    feather.replace();
    specIndex++;
}

function removeSpec(btn) {
    const rows = document.querySelectorAll('.spec-row');
    if (rows.length > 1) {
        btn.closest('.spec-row').remove();
    } else {
        toast.warning('Perhatian', 'Minimal harus ada satu baris spesifikasi');
    }
}
</script>
@endpush

