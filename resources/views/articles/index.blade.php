@extends('layouts.app')

@section('title', 'Berita & Artikel | Agni Farm')

@section('content')
<div class="container py-5 mt-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 font-weight-bold mb-3">Berita & Artikel</h1>
            <p class="lead text-muted">Informasi terbaru seputar pertanian dan kegiatan Agni Farm.</p>
        </div>
    </div>

    <div class="row">
        @forelse($articles as $article)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 hover-lift">
                <a href="{{ route('articles.show', $article) }}" class="d-block overflow-hidden rounded-top">
                    <img src="{{ $article->image_url }}" class="card-img-top" alt="{{ $article->title }}" style="height: 200px; object-fit: cover; transition: transform 0.3s ease;">
                </a>
                <div class="card-body d-flex flex-column">
                    <div class="text-sm text-primary font-weight-bold mb-2">
                        {{ $article->created_at->format('d M Y') }}
                    </div>
                    <h5 class="card-title font-weight-bold mb-2">
                        <a href="{{ route('articles.show', $article) }}" class="text-dark text-decoration-none stretched-link">
                            {{ $article->title }}
                        </a>
                    </h5>
                    <p class="card-text text-muted mb-4 small">
                        {{ Str::limit($article->excerpt ?? strip_tags($article->content), 100) }}
                    </p>
                    <div class="mt-auto d-flex align-items-center">
                        <span class="text-sm font-weight-medium">Baca Selengkapnya</span>
                        <i class="feather-arrow-right ms-2" style="width: 14px; height: 14px;"></i>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="mb-3">
                <i class="feather-file-text text-muted" style="width: 48px; height: 48px; stroke-width: 1px;"></i>
            </div>
            <h4 class="text-muted">Belum ada artikel.</h4>
            <p class="text-muted">Kembali lagi nanti untuk update terbaru.</p>
        </div>
        @endforelse
    </div>

    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
            {{ $articles->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .hover-lift:hover .card-img-top {
        transform: scale(1.05);
    }
</style>
@endpush
