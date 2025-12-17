@extends('admin.layouts.app')

@section('title', 'Kelola Artikel')

@section('breadcrumb')
    <span style="color: #374151; font-weight: 500;">Artikel</span>
@endsection

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

@if($articles->count() > 0)
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
    @foreach($articles as $article)
    <div>
        <div class="card h-100" style="border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;">
            <!-- Article Image -->
            <div style="height: 180px; position: relative; overflow: hidden;">
                @if($article->image_url)
                    <img src="{{ $article->image_url }}" alt="{{ $article->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #f0f9ff 0%, #dcfce7 100%); display: flex; align-items: center; justify-content: center;">
                        <i data-feather="file-text" style="width: 48px; height: 48px; color: #15803d;"></i>
                    </div>
                @endif

                <!-- Status Badge -->
                <div style="position: absolute; top: 12px; left: 12px;">
                    @if($article->is_published)
                        <span class="badge" style="background: #16a34a; color: white; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                            <i data-feather="check-circle" style="width: 12px; height: 12px; margin-right: 4px;"></i>
                            Published
                        </span>
                    @else
                        <span class="badge" style="background: #6b7280; color: white; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                            <i data-feather="clock" style="width: 12px; height: 12px; margin-right: 4px;"></i>
                            Draft
                        </span>
                    @endif
                </div>

                <!-- YouTube Badge -->
                @if($article->youtube_url)
                <div style="position: absolute; top: 12px; right: 12px;">
                    <span class="badge" style="background: #dc2626; color: white; padding: 6px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                        <i data-feather="youtube" style="width: 12px; height: 12px;"></i>
                    </span>
                </div>
                @endif

                <!-- Overlay Gradient -->
                <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 60px; background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);"></div>

                <!-- Views Counter -->
                <div style="position: absolute; bottom: 12px; left: 12px; color: white; font-size: 12px; display: flex; align-items: center; gap: 4px;">
                    <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                    {{ number_format($article->views ?? 0) }} views
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body" style="padding: 20px;">
                <h5 style="font-weight: 700; font-size: 16px; margin-bottom: 8px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ $article->title }}
                </h5>
                <p style="color: #6b7280; font-size: 13px; margin-bottom: 12px; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ Str::limit($article->excerpt ?? strip_tags($article->content), 80) }}
                </p>

                <div style="display: flex; align-items: center; gap: 8px; color: #9ca3af; font-size: 12px; margin-bottom: 16px;">
                    <i data-feather="calendar" style="width: 14px; height: 14px;"></i>
                    {{ $article->created_at->format('d M Y') }}
                    <span style="margin: 0 4px;">•</span>
                    <i data-feather="user" style="width: 14px; height: 14px;"></i>
                    {{ $article->user->name ?? 'Admin' }}
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('articles.show', $article) }}" target="_blank" class="btn btn-sm" style="flex: 1; background: #f3f4f6; color: #374151; border: none; border-radius: 8px; padding: 8px 12px; font-size: 13px; font-weight: 500;">
                        <i data-feather="external-link" style="width: 14px; height: 14px;"></i>
                        Lihat
                    </a>
                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm" style="flex: 1; background: #16a34a; color: white; border: none; border-radius: 8px; padding: 8px 12px; font-size: 13px; font-weight: 500;">
                        <i data-feather="edit-2" style="width: 14px; height: 14px;"></i>
                        Edit
                    </a>
                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Yakin hapus artikel ini?')" style="flex-shrink: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm" style="background: #fee2e2; color: #dc2626; border: none; border-radius: 8px; padding: 8px 12px;">
                            <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="d-flex justify-content-between align-items-center mt-4">
    <span class="text-muted small">Menampilkan {{ $articles->firstItem() ?? 0 }} - {{ $articles->lastItem() ?? 0 }} dari {{ $articles->total() }} artikel</span>
    {{ $articles->links() }}
</div>
@else
<div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
    <div class="card-body text-center py-5">
        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #f0f9ff, #dcfce7); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
            <i data-feather="file-text" style="width: 40px; height: 40px; color: #15803d;"></i>
        </div>
        <h4 style="font-weight: 700; margin-bottom: 8px;">Belum Ada Artikel</h4>
        <p style="color: #6b7280; margin-bottom: 24px; max-width: 400px; margin-left: auto; margin-right: auto;">Mulai buat artikel pertama Anda untuk menarik pengunjung dan meningkatkan SEO website</p>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary" style="padding: 12px 24px; border-radius: 10px;">
            <i data-feather="plus" style="width: 18px; height: 18px; margin-right: 8px;"></i>
            Buat Artikel Pertama
        </a>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.12) !important;
    }
</style>
@endpush
