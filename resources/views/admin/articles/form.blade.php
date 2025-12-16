@extends('admin.layouts.app')

@section('title', $article->exists ? 'Edit Artikel' : 'Buat Artikel Baru')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">Artikel</a></li>
                <li class="breadcrumb-item active">{{ $article->exists ? 'Edit' : 'Buat Baru' }}</li>
            </ol>
        </nav>
        <h1 class="page-title">
            <i data-feather="{{ $article->exists ? 'edit-2' : 'plus-circle' }}" class="page-title-icon"></i>
            {{ $article->exists ? 'Edit Artikel' : 'Buat Artikel Baru' }}
        </h1>
    </div>
</div>

<form action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($article->exists)
        @method('PUT')
    @endif

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Konten Artikel</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label for="title" class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control form-control-lg @error('title') is-invalid @enderror"
                               id="title"
                               name="title"
                               value="{{ old('title', $article->title) }}"
                               placeholder="Masukkan judul artikel yang menarik..."
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="excerpt" class="form-label">Kutipan/Ringkasan</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                  id="excerpt"
                                  name="excerpt"
                                  rows="3"
                                  placeholder="Ringkasan singkat artikel untuk ditampilkan di halaman daftar...">{{ old('excerpt', $article->excerpt) }}</textarea>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Opsional. Jika kosong, akan menggunakan potongan dari konten.</small>
                    </div>

                    <div class="mb-0">
                        <label for="content" class="form-label">Isi Artikel <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror"
                                  id="content"
                                  name="content"
                                  rows="15"
                                  placeholder="Tulis isi artikel lengkap Anda di sini..."
                                  required>{{ old('content', $article->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Publish Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pengaturan Publikasi</h5>
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_published">
                            <strong>Publikasikan Artikel</strong>
                            <small class="d-block text-muted">Artikel akan terlihat di website</small>
                        </label>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i data-feather="save" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                            {{ $article->exists ? 'Simpan Perubahan' : 'Publikasikan Artikel' }}
                        </button>
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-light">Batal</a>
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Gambar Utama</h5>
                </div>
                <div class="card-body">
                    @if($article->image)
                        <div class="mb-3">
                            <img src="{{ $article->image_url }}" alt="Preview" class="img-fluid rounded" style="max-height: 200px; width: 100%; object-fit: cover;">
                        </div>
                    @endif
                    <input type="file"
                           class="form-control @error('image') is-invalid @enderror"
                           id="image"
                           name="image"
                           accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Format: JPG, PNG, WebP. Maks: 2MB</small>
                </div>
            </div>

            <!-- YouTube Video -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i data-feather="youtube" style="width: 18px; height: 18px; color: #ff0000; margin-right: 8px;"></i>
                        Video YouTube
                    </h5>
                </div>
                <div class="card-body">
                    <input type="url"
                           class="form-control @error('youtube_url') is-invalid @enderror"
                           id="youtube_url"
                           name="youtube_url"
                           value="{{ old('youtube_url', $article->youtube_url) }}"
                           placeholder="https://www.youtube.com/watch?v=...">
                    @error('youtube_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Opsional. Video akan ditampilkan di halaman artikel.</small>

                    @if($article->youtube_url)
                        <div class="mt-3 ratio ratio-16x9">
                            <iframe src="{{ $article->youtube_embed_url }}" title="Video Preview" allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('styles')
<style>
    #content {
        font-family: 'Menlo', 'Monaco', 'Courier New', monospace;
        font-size: 14px;
        line-height: 1.6;
    }
</style>
@endpush
