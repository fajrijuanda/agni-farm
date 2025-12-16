@extends('layouts.app')

@section('title', $article->title . ' | Agni Farm')

@section('content')
<section class="section-lg" style="padding-top: calc(var(--header-height) + var(--spacing-10));">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 350px; gap: var(--spacing-10);">
            <!-- Main Content -->
            <article>
                <!-- Breadcrumb -->
                <nav style="margin-bottom: var(--spacing-6);">
                    <div style="display: flex; gap: var(--spacing-2); font-size: var(--font-size-sm); color: var(--color-gray-500);">
                        <a href="{{ route('home') }}" style="color: var(--color-primary-600); text-decoration: none;">Beranda</a>
                        <span>/</span>
                        <a href="{{ route('articles.index') }}" style="color: var(--color-primary-600); text-decoration: none;">Artikel</a>
                        <span>/</span>
                        <span>{{ Str::limit($article->title, 30) }}</span>
                    </div>
                </nav>

                <h1 style="font-size: var(--font-size-4xl); font-weight: 800; color: var(--color-gray-900); margin-bottom: var(--spacing-4); line-height: 1.2;">
                    {{ $article->title }}
                </h1>

                <div style="display: flex; align-items: center; gap: var(--spacing-4); margin-bottom: var(--spacing-8); color: var(--color-gray-500); font-size: var(--font-size-sm);">
                    <span style="display: flex; align-items: center; gap: var(--spacing-2);">
                        <i data-feather="calendar" style="width: 16px; height: 16px;"></i>
                        {{ $article->published_at ? $article->published_at->format('d F Y') : $article->created_at->format('d F Y') }}
                    </span>
                    <span style="display: flex; align-items: center; gap: var(--spacing-2);">
                        <i data-feather="user" style="width: 16px; height: 16px;"></i>
                        {{ $article->user->name ?? 'Admin' }}
                    </span>
                    <span style="display: flex; align-items: center; gap: var(--spacing-2);">
                        <i data-feather="eye" style="width: 16px; height: 16px;"></i>
                        {{ number_format($article->views) }} Dilihat
                    </span>
                </div>

                @if($article->image)
                <div style="border-radius: var(--radius-xl); overflow: hidden; margin-bottom: var(--spacing-8); box-shadow: var(--shadow-lg);">
                    <img src="{{ $article->image_url }}" alt="{{ $article->title }}" style="width: 100%; height: auto;">
                </div>
                @endif

                @if($article->youtube_embed_url)
                <div class="video-container">
                    <iframe src="{{ $article->youtube_embed_url }}"
                            title="{{ $article->title }}"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
                @endif

                <div class="article-content">
                    {!! nl2br(e($article->content)) !!}
                </div>

                <hr style="margin: var(--spacing-10) 0; border: none; border-top: 1px solid var(--color-gray-200);">

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">
                        <i data-feather="arrow-left" style="width: 18px; height: 18px;"></i>
                        Kembali ke Artikel
                    </a>

                    <div style="display: flex; gap: var(--spacing-2);">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                           target="_blank"
                           style="width: 40px; height: 40px; background: #1877f2; color: white; border-radius: var(--radius-full); display: flex; align-items: center; justify-content: center;">
                            <i data-feather="facebook" style="width: 18px; height: 18px;"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}"
                           target="_blank"
                           style="width: 40px; height: 40px; background: #1da1f2; color: white; border-radius: var(--radius-full); display: flex; align-items: center; justify-content: center;">
                            <i data-feather="twitter" style="width: 18px; height: 18px;"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}"
                           target="_blank"
                           style="width: 40px; height: 40px; background: #25d366; color: white; border-radius: var(--radius-full); display: flex; align-items: center; justify-content: center;">
                            <i data-feather="message-circle" style="width: 18px; height: 18px;"></i>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Sidebar -->
            <aside class="article-sidebar">
                <!-- Recent Articles -->
                <div class="sidebar-widget">
                    <h3 class="sidebar-title">Artikel Terbaru</h3>
                    @foreach($recentArticles as $recent)
                    <div class="recent-article-item">
                        <div class="recent-article-thumb">
                            <a href="{{ route('articles.show', $recent) }}">
                                <img src="{{ $recent->image_url }}" alt="{{ $recent->title }}">
                            </a>
                        </div>
                        <div class="recent-article-info">
                            <h4 class="recent-article-title">
                                <a href="{{ route('articles.show', $recent) }}">{{ Str::limit($recent->title, 45) }}</a>
                            </h4>
                            <span class="recent-article-date">{{ $recent->published_at ? $recent->published_at->format('d M Y') : $recent->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- CTA Widget -->
                <div class="sidebar-widget" style="background: linear-gradient(135deg, var(--color-primary-600), var(--color-primary-700)); color: white;">
                    <h3 style="font-size: var(--font-size-lg); font-weight: 700; margin-bottom: var(--spacing-3);">🌱 Kunjungi Toko Kami</h3>
                    <p style="font-size: var(--font-size-sm); opacity: 0.9; margin-bottom: var(--spacing-4);">Dapatkan bibit tanaman berkualitas dengan harga terjangkau!</p>
                    <a href="https://shopee.co.id/agnifarm" target="_blank" class="btn" style="background: white; color: var(--color-primary-700); width: 100%;">
                        <i data-feather="shopping-bag" style="width: 16px; height: 16px;"></i>
                        Beli di Shopee
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    @media (max-width: 992px) {
        section > .container > div {
            grid-template-columns: 1fr !important;
        }
        .article-sidebar {
            position: static;
        }
    }
</style>
@endpush
