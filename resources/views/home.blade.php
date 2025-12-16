@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">
                🌿 Supplier Bibit Tanaman Berkualitas
            </div>
            <h1 class="hero-title">
                Tumbuhkan <span>Impianmu</span> Bersama Kami
            </h1>
            <p class="hero-description">
                Agni Farm menyediakan berbagai bibit tanaman berkualitas dengan harga terjangkau.
                Belanja mudah via Shopee dengan pengiriman ke seluruh Indonesia.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">
                    <i data-feather="grid" style="width: 20px; height: 20px;"></i>
                    Lihat Catalog
                </a>
                <a href="https://shopee.co.id/agnifarm" target="_blank" class="btn btn-outline btn-lg">
                    <i data-feather="shopping-bag" style="width: 20px; height: 20px;"></i>
                    Kunjungi Shopee
                </a>
            </div>
        </div>
    </div>
</section>

<!-- About Preview Section -->
<section class="section-lg" style="background: white;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
            <div>
                <span class="section-badge">Tentang Kami</span>
                <h2 style="font-size: var(--font-size-3xl); font-weight: 700; color: var(--color-gray-900); margin-bottom: var(--spacing-4);">
                    Agni Farm, Partner Berkebun Anda
                </h2>
                <p style="color: var(--color-gray-600); line-height: 1.8; margin-bottom: var(--spacing-4);">
                    Kami adalah supplier bibit tanaman yang berlokasi di Jawa Barat. Dengan pengalaman bertahun-tahun,
                    kami berkomitmen menyediakan bibit tanaman berkualitas tinggi dengan harga yang terjangkau.
                </p>
                <p style="color: var(--color-gray-600); line-height: 1.8; margin-bottom: var(--spacing-6);">
                    Setiap bibit yang kami jual telah melalui proses seleksi ketat untuk memastikan kualitas terbaik
                    sampai di tangan Anda.
                </p>
                <a href="{{ route('about') }}" class="btn btn-secondary">
                    Pelajari Lebih Lanjut
                    <i data-feather="arrow-right" style="width: 18px; height: 18px;"></i>
                </a>
            </div>
            <div style="background: linear-gradient(135deg, var(--color-primary-100) 0%, var(--color-primary-200) 100%); border-radius: var(--radius-2xl); padding: 40px; display: flex; align-items: center; justify-content: center; min-height: 400px;">
                <div style="text-align: center;">
                    <span style="font-size: 80px;">🌱</span>
                    <p style="color: var(--color-primary-700); font-weight: 600; margin-top: var(--spacing-4);">Agni Farm</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
@if($featuredProducts->count() > 0)
<section class="section-lg">
    <div class="container">
        <div class="section-header">
            <span class="section-badge">Produk Unggulan</span>
            <h2 class="section-title">Produk Pilihan Kami</h2>
            <p class="section-description">
                Bibit tanaman terbaik yang direkomendasikan untuk Anda
            </p>
        </div>

        <div class="products-grid">
            @foreach($featuredProducts as $product)
                <div class="product-card">
                    <div class="product-card-image">
                        @if($product->primary_image)
                            <img src="{{ asset('storage/' . $product->primary_image->image_path) }}" alt="{{ $product->name }}">
                        @else
                            <div style="width: 100%; height: 100%; background: var(--color-gray-100); display: flex; align-items: center; justify-content: center;">
                                <i data-feather="image" style="width: 48px; height: 48px; color: var(--color-gray-300);"></i>
                            </div>
                        @endif
                        @if($product->has_discount)
                            <span class="product-badge">-{{ $product->discount_percentage }}%</span>
                        @endif
                    </div>
                    <div class="product-card-body">
                        <span class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        <h3 class="product-title">
                            <a href="{{ route('catalog.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <div class="product-price">
                            @if($product->has_discount)
                                <span class="product-price-current">{{ $product->formatted_discount_price }}</span>
                                <span class="product-price-original">{{ $product->formatted_price }}</span>
                            @else
                                <span class="product-price-current">{{ $product->formatted_price }}</span>
                            @endif
                        </div>
                        <div class="product-card-footer">
                            <a href="{{ route('catalog.show', $product->slug) }}" class="btn btn-secondary">
                                <i data-feather="eye" style="width: 16px; height: 16px;"></i>
                                Detail
                            </a>
                            <a href="{{ $product->shopee_link }}" target="_blank" class="btn btn-shopee">
                                <i data-feather="shopping-bag" style="width: 16px; height: 16px;"></i>
                                Beli
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: var(--spacing-10);">
            <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">
                Lihat Semua Produk
                <i data-feather="arrow-right" style="width: 20px; height: 20px;"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Categories Section -->
@if($categories->count() > 0)
<section class="section-lg" style="background: white;">
    <div class="container">
        <div class="section-header">
            <span class="section-badge">Kategori Produk</span>
            <h2 class="section-title">Temukan Berdasarkan Kategori</h2>
            <p class="section-description">
                Berbagai jenis bibit tanaman tersedia untuk kebutuhan Anda
            </p>
        </div>

        <div class="categories-grid">
            @foreach($categories as $category)
                <a href="{{ route('catalog', ['category' => $category->id]) }}" class="category-card">
                    <div class="category-icon">
                        {{ $category->icon ?? '🌿' }}
                    </div>
                    <h3 class="category-name">{{ $category->name }}</h3>
                    <p class="category-count">{{ $category->products_count }} produk</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Latest Products Section -->
@if($latestProducts->count() > 0)
<section class="section-lg">
    <div class="container">
        <div class="section-header">
            <span class="section-badge">Produk Terbaru</span>
            <h2 class="section-title">Baru Ditambahkan</h2>
            <p class="section-description">
                Produk terbaru yang bisa Anda dapatkan
            </p>
        </div>

        <div class="products-grid">
            @foreach($latestProducts as $product)
                <div class="product-card">
                    <div class="product-card-image">
                        @if($product->primary_image)
                            <img src="{{ asset('storage/' . $product->primary_image->image_path) }}" alt="{{ $product->name }}">
                        @else
                            <div style="width: 100%; height: 100%; background: var(--color-gray-100); display: flex; align-items: center; justify-content: center;">
                                <i data-feather="image" style="width: 48px; height: 48px; color: var(--color-gray-300);"></i>
                            </div>
                        @endif
                        @if($product->has_discount)
                            <span class="product-badge">-{{ $product->discount_percentage }}%</span>
                        @endif
                    </div>
                    <div class="product-card-body">
                        <span class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        <h3 class="product-title">
                            <a href="{{ route('catalog.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <div class="product-price">
                            @if($product->has_discount)
                                <span class="product-price-current">{{ $product->formatted_discount_price }}</span>
                                <span class="product-price-original">{{ $product->formatted_price }}</span>
                            @else
                                <span class="product-price-current">{{ $product->formatted_price }}</span>
                            @endif
                        </div>
                        <div class="product-card-footer">
                            <a href="{{ route('catalog.show', $product->slug) }}" class="btn btn-secondary">
                                <i data-feather="eye" style="width: 16px; height: 16px;"></i>
                                Detail
                            </a>
                            <a href="{{ $product->shopee_link }}" target="_blank" class="btn btn-shopee">
                                <i data-feather="shopping-bag" style="width: 16px; height: 16px;"></i>
                                Beli
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Siap Memulai Berkebun?</h2>
            <p class="cta-description">
                Dapatkan bibit tanaman berkualitas dengan harga terjangkau. Belanja sekarang di Shopee!
            </p>
            <div style="display: flex; gap: var(--spacing-4); justify-content: center; flex-wrap: wrap;">
                <a href="https://shopee.co.id/agnifarm" target="_blank" class="btn btn-secondary btn-lg">
                    <i data-feather="shopping-bag" style="width: 20px; height: 20px;"></i>
                    Kunjungi Shopee Kami
                </a>
                <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-whatsapp btn-lg">
                    <i data-feather="message-circle" style="width: 20px; height: 20px;"></i>
                    Chat WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    @media (max-width: 1024px) {
        [style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush
