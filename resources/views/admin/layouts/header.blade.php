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
        <div class="header-user-menu" style="position: relative;">
            <button class="btn btn-ghost" id="notifMenuToggle" title="Notifikasi" style="position: relative;">
                <i data-feather="bell"></i>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span style="position: absolute; top: 4px; right: 4px; width: 8px; height: 8px; background: var(--color-error); border-radius: 50%;"></span>
                @endif
            </button>

            <div class="dropdown-menu" id="notifDropdown" style="display: none; position: absolute; top: 100%; right: 0; margin-top: 8px; background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 320px; z-index: 100;">
                <div style="padding: 16px; border-bottom: 1px solid var(--color-gray-100); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="margin: 0; font-size: 14px; font-weight: 600;">Notifikasi</h3>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <form action="{{ route('admin.notifications.read-all') }}" method="POST">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: var(--color-primary-600); font-size: 12px; cursor: pointer;">
                                Tandai semua dibaca
                            </button>
                        </form>
                    @endif
                </div>

                <div style="max-height: 300px; overflow-y: auto;">
                    @forelse(auth()->user()->notifications->take(5) as $notification)
                        <a href="{{ route('admin.notifications.read', $notification->id) }}" style="display: block; padding: 12px 16px; text-decoration: none; border-bottom: 1px solid var(--color-gray-50); background: {{ $notification->read_at ? 'white' : 'var(--color-primary-50)' }}">
                            <div style="display: flex; gap: 12px;">
                                <div style="width: 32px; height: 32px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--color-primary-500); border: 1px solid var(--color-primary-100); flex-shrink: 0;">
                                    <i data-feather="{{ $notification->data['icon'] ?? 'bell' }}" style="width: 16px; height: 16px;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 13px; font-weight: 600; color: var(--color-gray-800); margin-bottom: 2px;">
                                        {{ $notification->data['title'] ?? 'Notifikasi' }}
                                    </div>
                                    <div style="font-size: 12px; color: var(--color-gray-500); line-height: 1.4;">
                                        {{ $notification->data['message'] ?? '' }}
                                    </div>
                                    <div style="font-size: 11px; color: var(--color-gray-400); margin-top: 4px;">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div style="padding: 24px; text-align: center; color: var(--color-gray-500); font-size: 13px;">
                            <i data-feather="bell-off" style="width: 24px; height: 24px; margin-bottom: 8px; opacity: 0.5;"></i>
                            <p style="margin: 0;">Tidak ada notifikasi</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

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
                <a href="{{ route('admin.profile.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--color-gray-700); text-decoration: none; transition: background 0.15s;">
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
        const notifMenuToggle = document.getElementById('notifMenuToggle');
        const notifDropdown = document.getElementById('notifDropdown');

        function closeAllDropdowns() {
            if (userDropdown) userDropdown.style.display = 'none';
            if (notifDropdown) notifDropdown.style.display = 'none';
        }

        if (userMenuToggle && userDropdown) {
            userMenuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                const isHidden = userDropdown.style.display === 'none';
                closeAllDropdowns();
                if (isHidden) userDropdown.style.display = 'block';
            });
        }

        if (notifMenuToggle && notifDropdown) {
            notifMenuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                const isHidden = notifDropdown.style.display === 'none';
                closeAllDropdowns();
                if (isHidden) notifDropdown.style.display = 'block';
            });
        }

        document.addEventListener('click', function() {
            closeAllDropdowns();
        });

        // Prevent closing when clicking inside dropdown
        if (userDropdown) {
            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
        if (notifDropdown) {
            notifDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });
</script>
