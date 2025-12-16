@extends('admin.layouts.app')

@section('title', 'Kelola Artikel')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1 class="page-title">
            <i data-feather="file-text" class="page-title-icon"></i>
            Kelola Artikel
        </h1>
        <p class="page-description">Buat dan kelola artikel blog untuk website Anda</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
            <i data-feather="plus"></i>
            Tambah Artikel
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i data-feather="check-circle" style="width: 18px; height: 18px; margin-right: 8px;"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($articles->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px;">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>Artikel</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 120px;">Tanggal</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input article-checkbox" value="{{ $article->id }}">
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 60px; height: 60px; border-radius: 8px; overflow: hidden; flex-shrink: 0;">
                                    <img src="{{ $article->image_url }}" alt="{{ $article->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div>
                                    <h6 class="mb-1" style="font-weight: 600;">{{ Str::limit($article->title, 50) }}</h6>
                                    <p class="mb-0 text-muted small">{{ Str::limit($article->excerpt ?? strip_tags($article->content), 70) }}</p>
                                    @if($article->youtube_url)
                                        <span class="badge bg-danger mt-1"><i data-feather="youtube" style="width: 12px; height: 12px;"></i> Video</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($article->is_published)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted">{{ $article->created_at->format('d M Y') }}</span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                    <i data-feather="more-vertical" style="width: 16px; height: 16px;"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('articles.show', $article) }}" target="_blank">
                                            <i data-feather="eye" style="width: 14px; height: 14px; margin-right: 8px;"></i>
                                            Lihat
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.articles.edit', $article) }}">
                                            <i data-feather="edit-2" style="width: 14px; height: 14px; margin-right: 8px;"></i>
                                            Edit
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i data-feather="trash-2" style="width: 14px; height: 14px; margin-right: 8px;"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <span class="text-muted small">Menampilkan {{ $articles->firstItem() ?? 0 }} - {{ $articles->lastItem() ?? 0 }} dari {{ $articles->total() }} artikel</span>
            {{ $articles->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <div style="width: 80px; height: 80px; background: var(--color-gray-100); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i data-feather="file-text" style="width: 32px; height: 32px; color: var(--color-gray-400);"></i>
            </div>
            <h5 class="mb-2">Belum Ada Artikel</h5>
            <p class="text-muted mb-4">Mulai buat artikel pertama Anda untuk menarik pengunjung</p>
            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                <i data-feather="plus"></i>
                Buat Artikel Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
