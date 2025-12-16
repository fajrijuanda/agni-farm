<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Agni Farm - Supplier bibit tanaman berkualitas dari Jawa Barat. Belanja mudah via Shopee dengan harga terjangkau.')">
    <meta name="keywords" content="bibit tanaman, agni farm, tanaman hias, pertanian, shopee">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Agni Farm') - Bibit Tanaman Berkualitas</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="header" id="header">
        <div class="container header-container">
            <a href="{{ route('home') }}" class="header-logo">
                <span style="font-size: 32px;">🌱</span>
                <span class="header-logo-text">Agni Farm</span>
            </a>

            <nav class="header-nav">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Tentang Kami</a>
                <a href="{{ route('catalog') }}" class="nav-link {{ request()->routeIs('catalog*') ? 'active' : '' }}">Catalog</a>
                <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Kontak</a>
            </nav>

            <div class="header-actions">
                <a href="https://shopee.co.id/agnifarm" target="_blank" class="btn btn-primary btn-sm" style="padding: 8px 16px; font-size: 14px;">
                    <i data-feather="shopping-bag" style="width: 16px; height: 16px;"></i>
                    Shopee
                </a>
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <i data-feather="menu" style="width: 24px; height: 24px;"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('about') }}" class="mobile-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Tentang Kami</a>
        <a href="{{ route('catalog') }}" class="mobile-nav-link {{ request()->routeIs('catalog*') ? 'active' : '' }}">Catalog</a>
        <a href="{{ route('contact') }}" class="mobile-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Kontak</a>
        <a href="https://shopee.co.id/agnifarm" target="_blank" class="btn btn-shopee" style="margin-top: 20px; width: 100%;">
            <i data-feather="shopping-bag"></i>
            Kunjungi Shopee
        </a>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
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
                        <a href="#" title="Instagram"><i data-feather="instagram"></i></a>
                        <a href="#" title="Facebook"><i data-feather="facebook"></i></a>
                        <a href="#" title="WhatsApp"><i data-feather="message-circle"></i></a>
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
                        @foreach($footerCategories as $category)
                            <li><a href="{{ route('catalog', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                        @endforeach
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
                <p>Made with ❤️ in Indonesia</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Initialize Feather Icons
        feather.replace();

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        let menuOpen = false;

        mobileMenuToggle.addEventListener('click', function() {
            menuOpen = !menuOpen;
            mobileMenu.classList.toggle('open', menuOpen);
            this.innerHTML = menuOpen
                ? '<i data-feather="x" style="width: 24px; height: 24px;"></i>'
                : '<i data-feather="menu" style="width: 24px; height: 24px;"></i>';
            feather.replace();
        });
    </script>

    @stack('scripts')
</body>
</html>
