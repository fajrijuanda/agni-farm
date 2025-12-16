<!-- Admin Header -->
<header class="admin-header">
    <div class="header-left">
        <button class="header-toggle" id="sidebarToggle">
            <i data-feather="menu"></i>
        </button>

        <nav class="header-breadcrumb">
            @yield('breadcrumb')
        </nav>
    </div>

    <div class="header-actions">
        <!-- Search -->
        <button class="btn btn-ghost" title="Cari">
            <i data-feather="search"></i>
        </button>

        <!-- Notifications -->
        <button class="btn btn-ghost" title="Notifikasi">
            <i data-feather="bell"></i>
        </button>

        <!-- User Menu -->
        <div class="header-user-menu" style="position: relative;">
            <button class="btn btn-ghost" id="userMenuToggle" style="display: flex; align-items: center; gap: 8px;">
                <img src="{{ auth()->user()->avatar_url }}"
                     alt="{{ auth()->user()->name }}"
                     style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                <span style="font-weight: 500;">{{ auth()->user()->name }}</span>
                <i data-feather="chevron-down" style="width: 16px; height: 16px;"></i>
            </button>

            <div class="dropdown-menu" id="userDropdown" style="display: none; position: absolute; top: 100%; right: 0; margin-top: 8px; background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); min-width: 200px; z-index: 100;">
                <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--color-gray-700); text-decoration: none; transition: background 0.15s;">
                    <i data-feather="user" style="width: 18px; height: 18px;"></i>
                    Profil Saya
                </a>
                <a href="{{ route('admin.settings.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--color-gray-700); text-decoration: none; transition: background 0.15s;">
                    <i data-feather="settings" style="width: 18px; height: 18px;"></i>
                    Pengaturan
                </a>
                <hr style="margin: 8px 0; border: none; border-top: 1px solid var(--color-gray-100);">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--color-error); background: none; border: none; width: 100%; cursor: pointer; font-size: inherit; font-family: inherit; text-align: left; transition: background 0.15s;">
                        <i data-feather="log-out" style="width: 18px; height: 18px;"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<style>
    .sidebar-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 99;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .sidebar-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .dropdown-menu a:hover,
    .dropdown-menu button:hover {
        background: var(--color-gray-50);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userMenuToggle = document.getElementById('userMenuToggle');
        const userDropdown = document.getElementById('userDropdown');

        if (userMenuToggle && userDropdown) {
            userMenuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.style.display = userDropdown.style.display === 'none' ? 'block' : 'none';
            });

            document.addEventListener('click', function() {
                userDropdown.style.display = 'none';
            });
        }
    });
</script>
