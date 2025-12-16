@extends('layouts.app')

@section('title', 'Berita & Artikel')

@section('content')

@push('styles')
<style>
    /* Popular Slider Styles */
    .popular-slider {
        position: relative;
        border-radius: var(--radius-2xl);
        overflow: hidden;
        box-shadow: var(--shadow-xl);
        height: 400px;
        background: black;
    }

    .slider-wrapper {
        position: relative;
        height: 100%;
    }

    .slider-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
        pointer-events: none;
    }

    .slider-slide.active {
        opacity: 1;
        pointer-events: auto;
    }

    .slider-content {
        display: block;
        width: 100%;
        height: 100%;
        position: relative;
        color: white;
        text-decoration: none;
    }

    .slider-image {
        width: 100%;
        height: 100%;
        position: relative;
    }

    .slider-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .slider-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0.1) 100%);
    }

    .slider-info {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: var(--spacing-8);
        z-index: 2;
    }

    .slider-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        background: var(--color-primary-600);
        color: white;
        border-radius: var(--radius-full);
        font-size: var(--font-size-xs);
        font-weight: 600;
        margin-bottom: var(--spacing-3);
    }

    .slider-title {
        font-size: var(--font-size-3xl);
        font-weight: 800;
        margin-bottom: var(--spacing-2);
        line-height: 1.2;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .slider-meta {
        font-size: var(--font-size-sm);
        opacity: 0.8;
    }

    .slider-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(4px);
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 3;
        transition: background 0.3s;
    }

    .slider-nav:hover {
        background: rgba(255,255,255,0.4);
    }

    .slider-nav.prev { left: 20px; }
    .slider-nav.next { right: 20px; }

    .slider-dots {
        position: absolute;
        bottom: 20px;
        right: 20px;
        display: flex;
        gap: 8px;
        z-index: 3;
    }

    .slider-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .slider-dot.active {
        background: white;
        transform: scale(1.2);
    }

    @media (max-width: 768px) {
        .popular-slider { height: 300px; }
        .slider-title { font-size: var(--font-size-xl); }
        .slider-nav { display: none; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slider = document.getElementById('popularSlider');
        if (!slider) return;

        const slides = slider.querySelectorAll('.slider-slide');
        const dots = slider.querySelectorAll('.slider-dot');
        const prevBtn = document.getElementById('sliderPrev');
        const nextBtn = document.getElementById('sliderNext');
        let currentSlide = 0;
        let slideInterval;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            slides[index].classList.add('active');
            dots[index].classList.add('active');
            currentSlide = index;
        }

        function nextSlide() {
            let next = (currentSlide + 1) % slides.length;
            showSlide(next);
        }

        function prevSlide() {
            let prev = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(prev);
        }

        function startAutoSwipe() {
            slideInterval = setInterval(nextSlide, 5000);
        }

        function stopAutoSwipe() {
            clearInterval(slideInterval);
        }

        if (prevBtn) prevBtn.addEventListener('click', () => { stopAutoSwipe(); prevSlide(); startAutoSwipe(); });
        if (nextBtn) nextBtn.addEventListener('click', () => { stopAutoSwipe(); nextSlide(); startAutoSwipe(); });

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                stopAutoSwipe();
                showSlide(index);
                startAutoSwipe();
            });
        });

        // Initialize
        startAutoSwipe();

        // Pause on hover
        slider.addEventListener('mouseenter', stopAutoSwipe);
        slider.addEventListener('mouseleave', startAutoSwipe);
    });
</script>
@endpush
<!-- Hero Section -->
<section style="background: linear-gradient(135deg, var(--color-primary-700) 0%, var(--color-primary-800) 100%); padding: calc(var(--header-height) + 40px) 0 40px; text-align: center;">
    <div class="container">
        <span class="section-badge" style="background: rgba(255,255,255,0.2); color: white;">Blog & Artikel</span>
        <h1 style="font-size: var(--font-size-3xl); font-weight: 800; color: white; margin-bottom: var(--spacing-4);">
            Berita & Artikel Terbaru
        </h1>
        <p style="font-size: var(--font-size-lg); color: rgba(255,255,255,0.8); max-width: 600px; margin: 0 auto;">
            Tips berkebun, panduan perawatan tanaman, dan informasi menarik lainnya
        </p>
    </div>
</section>

<!-- Popular Articles Slider -->
@if(isset($popularArticles) && $popularArticles->count() > 0)
<section class="section-lg" style="padding-bottom: 0;">
    <div class="container">
        <h2 style="font-size: var(--font-size-xl); font-weight: 700; margin-bottom: var(--spacing-6); display: flex; align-items: center; gap: 8px;">
            <i data-feather="trending-up" style="color: var(--color-primary-600);"></i>
            Artikel Terpopuler
        </h2>

        <div class="popular-slider" id="popularSlider">
            <div class="slider-wrapper">
                @foreach($popularArticles as $index => $article)
                <div class="slider-slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                    <a href="{{ route('articles.show', $article) }}" class="slider-content">
                        <div class="slider-image">
                            <img src="{{ $article->image_url }}" alt="{{ $article->title }}">
                            <div class="slider-overlay"></div>
                        </div>
                        <div class="slider-info">
                            <span class="slider-badge">
                                <i data-feather="eye" style="width: 12px; height: 12px;"></i>
                                {{ number_format($article->views) }} Dilihat
                            </span>
                            <h3 class="slider-title">{{ Str::limit($article->title, 70) }}</h3>
                            <div class="slider-meta">
                                <span>{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <button class="slider-nav prev" id="sliderPrev"><i data-feather="chevron-left"></i></button>
            <button class="slider-nav next" id="sliderNext"><i data-feather="chevron-right"></i></button>

            <div class="slider-dots">
                @foreach($popularArticles as $index => $article)
                <button class="slider-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></button>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Articles Grid -->
<section class="section-lg">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 style="font-size: var(--font-size-xl); font-weight: 700;">Artikel Terbaru</h2>
        </div>

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
                    <div class="article-meta" style="justify-content: space-between;">
                        <span class="article-date">
                            <i data-feather="calendar" style="width: 14px; height: 14px;"></i>
                            {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                        </span>
                        <span style="font-size: var(--font-size-xs); color: var(--color-gray-500); display: flex; align-items: center; gap: 4px;">
                            <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                            {{ number_format($article->views) }}
                        </span>
                    </div>
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
            {{ $articles->links('vendor.pagination.custom') }}
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
