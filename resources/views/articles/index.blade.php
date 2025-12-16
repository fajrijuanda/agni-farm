@extends('layouts.app')

@section('title', 'Berita & Artikel')

@section('content')
<!-- Hero Section -->
<section style="background: linear-gradient(135deg, var(--color-primary-700) 0%, var(--color-primary-800) 100%); padding: calc(var(--header-height) + 60px) 0 60px; text-align: center;">
    <div class="container">
        <span class="section-badge" style="background: rgba(255,255,255,0.2); color: white;">Blog & Artikel</span>
        <h1 style="font-size: var(--font-size-4xl); font-weight: 800; color: white; margin-bottom: var(--spacing-4);">
            Berita & Artikel Terbaru
        </h1>
        <p style="font-size: var(--font-size-lg); color: rgba(255,255,255,0.8); max-width: 600px; margin: 0 auto;">
            Tips berkebun, panduan perawatan tanaman, dan informasi menarik lainnya dari Agni Farm
        </p>
    </div>
</section>

<!-- Articles Grid -->
<section class="section-lg">
    <div class="container">
        @if($articles->count() > 0)
        <div class="articles-grid">
            @foreach($articles as $article)
            <article class="article-card">
                <a href="{{ route('articles.show', $article) }}" class="article-card-image">
                    @if($article->image)
                        <img src="{{ $article->image_url }}" alt="{{ $article->title }}">
                    @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--color-primary-100), var(--color-primary-200)); display: flex; align-items: center; justify-content: center;">
                            <i data-feather="file-text" style="width: 48px; height: 48px; color: var(--color-primary-400);"></i>
                        </div>
                    @endif
                    <div class="article-card-overlay">
                        <span class="article-read-more">Baca Artikel</span>
                    </div>
                </a>
                <div class="article-card-body">
                    <div class="article-meta">
                        <span class="article-date">
                            <i data-feather="calendar" style="width: 14px; height: 14px;"></i>
                            {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                        </span>
                        @if($article->youtube_url)
                        <span style="display: flex; align-items: center; gap: 4px; color: #ff0000; font-size: var(--font-size-xs); font-weight: 600;">
                            <i data-feather="play-circle" style="width: 14px; height: 14px;"></i>
                            Video
                        </span>
                        @endif
                    </div>
                    <h3 class="article-card-title">
                        <a href="{{ route('articles.show', $article) }}">{{ Str::limit($article->title, 60) }}</a>
                    </h3>
                    <p class="article-card-excerpt">
                        {{ Str::limit($article->excerpt ?? strip_tags($article->content), 120) }}
                    </p>
                    <a href="{{ route('articles.show', $article) }}" class="article-link">
                        Baca Selengkapnya
                        <i data-feather="arrow-right" style="width: 16px; height: 16px;"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="display: flex; justify-content: center; margin-top: var(--spacing-12);">
            {{ $articles->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div style="text-align: center; padding: var(--spacing-16) 0;">
            <div style="width: 120px; height: 120px; background: var(--color-gray-100); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto var(--spacing-6);">
                <i data-feather="file-text" style="width: 48px; height: 48px; color: var(--color-gray-400);"></i>
            </div>
            <h3 style="font-size: var(--font-size-2xl); font-weight: 700; color: var(--color-gray-800); margin-bottom: var(--spacing-3);">
                Belum Ada Artikel
            </h3>
            <p style="color: var(--color-gray-500); margin-bottom: var(--spacing-6); max-width: 400px; margin-left: auto; margin-right: auto;">
                Kami sedang menyiapkan konten menarik untuk Anda. Kembali lagi nanti!
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i data-feather="arrow-left" style="width: 18px; height: 18px;"></i>
                Kembali ke Beranda
            </a>
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section style="background: var(--color-gray-50); padding: var(--spacing-16) 0;">
    <div class="container">
        <div style="background: linear-gradient(135deg, var(--color-primary-600), var(--color-primary-700)); border-radius: var(--radius-2xl); padding: var(--spacing-12); text-align: center;">
            <h2 style="font-size: var(--font-size-3xl); font-weight: 700; color: white; margin-bottom: var(--spacing-4);">
                Butuh Bibit Tanaman Berkualitas?
            </h2>
            <p style="color: rgba(255,255,255,0.9); margin-bottom: var(--spacing-6); max-width: 500px; margin-left: auto; margin-right: auto;">
                Kunjungi toko Shopee kami dan temukan berbagai bibit tanaman dengan harga terjangkau
            </p>
            @php
                $selectedRegion = session('selected_region', config('regions.default'));
                $regions = config('regions.regions');
                $currentRegion = $regions[$selectedRegion] ?? $regions['karawang'];
            @endphp
            <a href="{{ $currentRegion['shopee_link'] }}" target="_blank" class="btn btn-lg" style="background: white; color: var(--color-primary-700); font-weight: 600;">
                <i data-feather="shopping-bag" style="width: 20px; height: 20px;"></i>
                Kunjungi Shopee {{ $currentRegion['name'] }}
            </a>
        </div>
    </div>
</section>
@endsection
