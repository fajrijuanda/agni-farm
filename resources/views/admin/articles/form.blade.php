@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ $article->exists ? 'Edit Artikel' : 'Buah Artikel Baru' }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($article->exists)
                        @method('PUT')
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title" class="form-control-label">Judul Artikel</label>
                                <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title', $article->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="excerpt" class="form-control-label">Kutipan Singkat (Excerpt)</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror" name="excerpt" id="excerpt" rows="2">{{ old('excerpt', $article->excerpt) }}</textarea>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="content" class="form-control-label">Konten Artikel</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content" rows="10" required>{{ old('content', $article->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image" class="form-control-label">Gambar Utama</label>
                                @if($article->image)
                                    <div class="mb-3">
                                        <img src="{{ $article->image_url }}" alt="Preview" class="img-fluid border-radius-lg shadow">
                                    </div>
                                @endif
                                <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image" accept="image/*">
                                <small class="text-muted">Format: jpg, png, webp. Max: 2MB.</small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-4">
                                <div class="form-check form-switch ps-0">
                                    <input class="form-check-input ms-auto" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="is_published">Publish Artikel Ini?</label>
                                </div>
                            </div>

                            <hr class="horizontal dark my-4">

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.articles.index') }}" class="btn btn-light m-0 me-2">Batal</a>
                                <button type="submit" class="btn bg-gradient-primary m-0">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
