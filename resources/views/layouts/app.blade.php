<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Agni Farm - Supplier bibit tanaman berkualitas dari Jawa Barat. Belanja mudah via Shopee dengan harga terjangkau.')">
    <meta name="keywords" content="@yield('meta_keywords', 'bibit tanaman, agni farm, tanaman hias, bibit sayuran, bibit buah, pertanian, shopee, jawa barat')">
    <meta name="author" content="Agni Farm">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Agni Farm') - Bibit Tanaman Berkualitas">
    <meta property="og:description" content="@yield('meta_description', 'Agni Farm - Supplier bibit tanaman berkualitas dari Jawa Barat.')">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Agni Farm">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Agni Farm') - Bibit Tanaman Berkualitas">
    <meta name="twitter:description" content="@yield('meta_description', 'Agni Farm - Supplier bibit tanaman berkualitas dari Jawa Barat.')">
    <meta name="twitter:image" content="{{ asset('images/og-image.jpg') }}">

    <link rel="canonical" href="{{ url()->current() }}">

    <title>@yield('title', 'Agni Farm') - Bibit Tanaman Berkualitas</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#166534">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://unpkg.com">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">

    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "Agni Farm",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/logo.png') }}",
        "description": "Supplier bibit tanaman berkualitas dari Jawa Barat",
        "address": {
            "@@type": "PostalAddress",
            "addressLocality": "Jawa Barat",
            "addressCountry": "ID"
        },
        "contactPoint": {
            "@@type": "ContactPoint",
            "telephone": "+62-812-3456-7890",
            "contactType": "customer service"
        },
        "sameAs": [
            "https://shopee.co.id/agnifarm"
        ]
    }
    </script>

    @stack('styles')
</head>
<body class="page-transition">
    <header class="header" id="header">
        <div class="container header-container">
            <a href="{{ route('home') }}" class="header-logo">
                <span style="font-size: 32px;">🌱</span>
                <span class="header-logo-text">Agni Farm</span>
            </a>

            <nav class="header-nav" role="navigation" aria-label="Main navigation">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Tentang Kami</a>
                <a href="{{ route('articles.index') }}" class="nav-link {{ request()->routeIs('articles*') ? 'active' : '' }}">Artikel</a>
                <a href="{{ route('catalog') }}" class="nav-link {{ request()->routeIs('catalog*') ? 'active' : '' }}">Catalog</a>
                <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Kontak</a>
            </nav>

            <div class="header-actions">
                @php
                    $selectedRegionSlug = session('selected_region', 'karawang');
                    $regions = \App\Models\Region::orderBy('order_index')->get();
                    $currentRegion = $regions->firstWhere('slug', $selectedRegionSlug) ?? $regions->first();
                @endphp

                <!-- Region Selector -->
                <div class="region-selector" style="position: relative;">
                    <button type="button" class="btn btn-light btn-sm region-toggle" id="regionToggle" style="padding: 8px 16px; font-size: 14px; display: flex; align-items: center; gap: 6px; background: var(--color-gray-100); border: 1px solid var(--color-gray-200); border-radius: 8px; height: 38px;">
                        <i data-feather="map-pin" style="width: 16px; height: 16px; color: var(--color-primary-600);"></i>
                        <span>{{ $currentRegion->name ?? 'Pilih Region' }}</span>
                        <i data-feather="chevron-down" style="width: 14px; height: 14px;"></i>
                    </button>
                    <div class="region-dropdown" id="regionDropdown" style="display: none; position: absolute; top: 100%; right: 0; margin-top: 8px; background: white; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); min-width: 200px; z-index: 1000; overflow: hidden;">
                        <div style="padding: 12px 16px; background: var(--color-gray-50); border-bottom: 1px solid var(--color-gray-100);">
                            <p style="margin: 0; font-size: 12px; font-weight: 600; color: var(--color-gray-600); text-transform: uppercase; letter-spacing: 0.05em;">Pilih Lokasi Anda</p>
                        </div>
                        @foreach($regions as $region)
                        <form action="{{ route('set.region') }}" method="POST" style="margin: 0;">
                            @csrf
                            <input type="hidden" name="region" value="{{ $region->slug }}">
                            <button type="submit" class="region-option" style="width: 100%; padding: 12px 16px; border: none; background: {{ $selectedRegionSlug === $region->slug ? 'var(--color-primary-50)' : 'white' }}; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: background 0.2s;">
                                <span style="font-size: 18px;">📍</span>
                                <span style="font-weight: {{ $selectedRegionSlug === $region->slug ? '600' : '500' }}; color: {{ $selectedRegionSlug === $region->slug ? 'var(--color-primary-700)' : 'var(--color-gray-700)' }};">{{ $region->name }}</span>
                                @if($selectedRegionSlug === $region->slug)
                                <i data-feather="check" style="width: 16px; height: 16px; color: var(--color-primary-600); margin-left: auto;"></i>
                                @endif
                            </button>
                        </form>
                        @endforeach
                    </div>
                </div>

                <a href="{{ $currentRegion->shopee_url ?? '#' }}" target="_blank" rel="noopener" class="btn btn-primary btn-sm" style="padding: 8px 16px; font-size: 14px; height: 38px; display: flex; align-items: center; gap: 6px;">
                    <i data-feather="shopping-bag" style="width: 16px; height: 16px;"></i>
                    Shopee
                </a>
                <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle mobile menu" aria-expanded="false">
                    <i data-feather="menu" style="width: 24px; height: 24px;"></i>
                </button>
            </div>
        </div>
    </header>

    <div class="mobile-menu" id="mobileMenu" role="navigation" aria-label="Mobile navigation">
        <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('about') }}" class="mobile-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Tentang Kami</a>
        <a href="{{ route('articles.index') }}" class="mobile-nav-link {{ request()->routeIs('articles*') ? 'active' : '' }}">Artikel</a>
        <a href="{{ route('catalog') }}" class="mobile-nav-link {{ request()->routeIs('catalog*') ? 'active' : '' }}">Catalog</a>
        <a href="{{ route('contact') }}" class="mobile-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Kontak</a>

        <!-- Mobile Region Selector -->
        <div style="margin-top: 20px; padding: 16px; background: var(--color-gray-50); border-radius: 12px;">
            <p style="font-size: 12px; font-weight: 600; color: var(--color-gray-600); margin-bottom: 8px; text-transform: uppercase;">Lokasi Anda</p>
            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                @foreach($regions as $key => $region)
                <form action="{{ route('set.region') }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="region" value="{{ $key }}">
                    <button type="submit" style="padding: 8px 12px; border: 1px solid {{ $selectedRegion === $key ? 'var(--color-primary-500)' : 'var(--color-gray-200)' }}; background: {{ $selectedRegion === $key ? 'var(--color-primary-50)' : 'white' }}; color: {{ $selectedRegion === $key ? 'var(--color-primary-700)' : 'var(--color-gray-600)' }}; font-weight: 500; font-size: 13px; border-radius: 8px; cursor: pointer;">
                        {{ $region['icon'] }} {{ $region['name'] }}
                    </button>
                </form>
                @endforeach
            </div>
        </div>

        <a href="{{ $currentRegion['shopee_link'] }}" target="_blank" rel="noopener" class="btn btn-shopee" style="margin-top: 16px; width: 100%;">
            <i data-feather="shopping-bag"></i>
            Kunjungi Shopee {{ $currentRegion['name'] }}
        </a>
    </div>

    <main role="main">
        @yield('content')
    </main>

    <button class="scroll-to-top" id="scrollToTop" aria-label="Scroll to top">
        <i data-feather="arrow-up" style="width: 20px; height: 20px;"></i>
    </button>

    <footer class="footer" role="contentinfo">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="footer-logo">
                        <span style="font-size: 32px;">🌱</span>
                        <span class="footer-logo-text">Agni Farm</span>
                    </div>
                    <p class="footer-description">
                        Supplier bibit tanaman berkualitas dari Jawa Barat. Kami menyediakan berbagai jenis bibit tanaman dengan harga terjangkau dan kualitas terbaik.
                    </p>
                    <div class="footer-social">
                        <a href="#" title="Instagram" aria-label="Instagram"><i data-feather="instagram"></i></a>
                        <a href="#" title="Facebook" aria-label="Facebook"><i data-feather="facebook"></i></a>
                        <a href="https://wa.me/6281234567890" title="WhatsApp" aria-label="WhatsApp"><i data-feather="message-circle"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="footer-title">Menu</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                        <li><a href="{{ route('catalog') }}">Catalog Produk</a></li>
                        <li><a href="{{ route('contact') }}">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="footer-title">Kategori</h4>
                    <ul class="footer-links">
                        @php
                            $footerCategories = \App\Models\Category::active()->ordered()->take(5)->get();
                        @endphp
                        @forelse($footerCategories as $category)
                            <li><a href="{{ route('catalog', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                        @empty
                            <li><a href="{{ route('catalog') }}">Lihat Semua</a></li>
                        @endforelse
                    </ul>
                </div>

                <div>
                    <h4 class="footer-title">Kontak</h4>
                    <ul class="footer-links">
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <i data-feather="map-pin" style="width: 16px; height: 16px;"></i>
                            Jawa Barat, Indonesia
                        </li>
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <i data-feather="phone" style="width: 16px; height: 16px;"></i>
                            +62 812 3456 7890
                        </li>
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <i data-feather="mail" style="width: 16px; height: 16px;"></i>
                            info@agnifarm.com
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Agni Farm. All rights reserved.</p>
                <p>Made with Love in Indonesia</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            const header = document.getElementById('header');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });

            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            let menuOpen = false;

            mobileMenuToggle.addEventListener('click', function() {
                menuOpen = !menuOpen;
                mobileMenu.classList.toggle('open', menuOpen);
                this.setAttribute('aria-expanded', menuOpen);
                this.innerHTML = menuOpen
                    ? '<i data-feather="x" style="width: 24px; height: 24px;"></i>'
                    : '<i data-feather="menu" style="width: 24px; height: 24px;"></i>';
                feather.replace();
            });

            const scrollToTopBtn = document.getElementById('scrollToTop');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 500) {
                    scrollToTopBtn.classList.add('visible');
                } else {
                    scrollToTopBtn.classList.remove('visible');
                }
            });

            scrollToTopBtn.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // Region dropdown toggle
            const regionToggle = document.getElementById('regionToggle');
            const regionDropdown = document.getElementById('regionDropdown');
            if (regionToggle && regionDropdown) {
                regionToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    regionDropdown.style.display = regionDropdown.style.display === 'none' ? 'block' : 'none';
                });
                document.addEventListener('click', function(e) {
                    if (!regionToggle.contains(e.target) && !regionDropdown.contains(e.target)) {
                        regionDropdown.style.display = 'none';
                    }
                });
            }

            const animateElements = document.querySelectorAll('.animate-on-scroll, .animate-stagger');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

            animateElements.forEach(el => observer.observe(el));
        });
    </script>

    @stack('scripts')
</body>
</html>
