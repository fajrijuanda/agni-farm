<!-- Admin Sidebar -->
<aside class="admin-sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Agni Farm" onerror="this.style.display='none'">
        <div>
            <h1>AGNI FARM</h1>
            <span>Admin Panel</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Menu</div>

            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i data-feather="grid" class="nav-item-icon"></i>
                Dashboard
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Catalog</div>

            <a href="{{ route('admin.catalog.index') ?? '#' }}" class="nav-item {{ request()->routeIs('admin.catalog.*') ? 'active' : '' }}">
                <i data-feather="package" class="nav-item-icon"></i>
                Semua Produk
            </a>

            <a href="{{ route('admin.catalog.create') ?? '#' }}" class="nav-item {{ request()->routeIs('admin.catalog.create') ? 'active' : '' }}">
                <i data-feather="plus-circle" class="nav-item-icon"></i>
                Tambah Produk
            </a>

            <a href="{{ route('admin.categories.index') ?? '#' }}" class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i data-feather="folder" class="nav-item-icon"></i>
                Kategori
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Lainnya</div>

            @php
                $unreadContacts = \App\Models\Contact::unread()->count();
            @endphp

            <a href="{{ route('admin.contacts.index') ?? '#' }}" class="nav-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <i data-feather="mail" class="nav-item-icon"></i>
                Pesan Masuk
                @if($unreadContacts > 0)
                    <span class="nav-item-badge">{{ $unreadContacts }}</span>
                @endif
            </a>

            <a href="{{ route('admin.settings.index') ?? '#' }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i data-feather="settings" class="nav-item-icon"></i>
                Pengaturan
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Website</div>

            <a href="{{ route('home') }}" target="_blank" class="nav-item">
                <i data-feather="external-link" class="nav-item-icon"></i>
                Lihat Website
            </a>
        </div>
    </nav>

    <!-- User Info -->
    <div class="sidebar-user">
        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="sidebar-user-avatar">
        <div class="sidebar-user-info">
            <h4>{{ auth()->user()->name }}</h4>
            <span>Administrator</span>
        </div>
    </div>
</aside>
