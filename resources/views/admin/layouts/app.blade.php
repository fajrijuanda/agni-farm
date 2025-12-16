<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Agni Farm Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">

    @stack('styles')
</head>
<body>
    <!-- Loading Screen -->
    <div class="loading-screen" id="loadingScreen">
        <div class="loading-spinner"></div>
        <p class="loading-text">Memuat...</p>
    </div>

    <div class="admin-layout">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header -->
            @include('admin.layouts.header')

            <!-- Content Area -->
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Modal Container -->
    <div class="modal-backdrop" id="modalBackdrop">
        <div class="modal" id="modal">
            <!-- Modal content will be injected here -->
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Initialize Feather Icons
        feather.replace();

        // Hide loading screen when page is loaded
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('loadingScreen').classList.add('hide');
            }, 500);
        });

        // Sidebar Toggle
        const sidebar = document.querySelector('.admin-sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.createElement('div');
        sidebarOverlay.className = 'sidebar-overlay';
        document.body.appendChild(sidebarOverlay);

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
                sidebarOverlay.classList.toggle('active');
            });

            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('active');
            });
        }
    </script>

    <!-- Toast Notification System -->
    <script>
        const toast = {
            container: document.getElementById('toastContainer'),

            show(type, title, message, duration = 5000) {
                const toastEl = document.createElement('div');
                toastEl.className = `toast ${type}`;

                const icons = {
                    success: 'check-circle',
                    error: 'x-circle',
                    warning: 'alert-triangle',
                    info: 'info'
                };

                toastEl.innerHTML = `
                    <i data-feather="${icons[type]}" class="toast-icon"></i>
                    <div class="toast-content">
                        <div class="toast-title">${title}</div>
                        ${message ? `<div class="toast-message">${message}</div>` : ''}
                    </div>
                    <button class="toast-close" onclick="this.closest('.toast').remove()">
                        <i data-feather="x"></i>
                    </button>
                `;

                this.container.appendChild(toastEl);
                feather.replace();

                if (duration > 0) {
                    setTimeout(() => {
                        toastEl.classList.add('leaving');
                        setTimeout(() => toastEl.remove(), 300);
                    }, duration);
                }

                return toastEl;
            },

            success(title, message) {
                return this.show('success', title, message);
            },

            error(title, message) {
                return this.show('error', title, message);
            },

            warning(title, message) {
                return this.show('warning', title, message);
            },

            info(title, message) {
                return this.show('info', title, message);
            }
        };
    </script>

    <!-- Modal System -->
    <script>
        const modal = {
            backdrop: document.getElementById('modalBackdrop'),
            container: document.getElementById('modal'),

            open(content) {
                this.container.innerHTML = content;
                this.backdrop.classList.add('active');
                feather.replace();
            },

            close() {
                this.backdrop.classList.remove('active');
            },

            confirm(options) {
                const {
                    title = 'Konfirmasi',
                    message = 'Apakah Anda yakin?',
                    type = 'danger',
                    confirmText = 'Ya, Lanjutkan',
                    cancelText = 'Batal',
                    onConfirm = () => {},
                    onCancel = () => {}
                } = options;

                const icons = {
                    danger: 'alert-triangle',
                    warning: 'alert-circle',
                    info: 'info'
                };

                const content = `
                    <div class="modal-confirm ${type}">
                        <div class="modal-body">
                            <div class="modal-icon">
                                <i data-feather="${icons[type]}"></i>
                            </div>
                            <h3>${title}</h3>
                            <p>${message}</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" onclick="modal.close(); (${onCancel.toString()})();">
                                ${cancelText}
                            </button>
                            <button class="btn btn-${type === 'danger' ? 'danger' : 'primary'}" onclick="modal.close(); (${onConfirm.toString()})();">
                                ${confirmText}
                            </button>
                        </div>
                    </div>
                `;

                this.open(content);
            },

            alert(title, message, type = 'info') {
                return this.confirm({
                    title,
                    message,
                    type,
                    confirmText: 'OK',
                    cancelText: '',
                    onConfirm: () => {},
                    onCancel: () => {}
                });
            }
        };

        // Close modal when clicking backdrop
        modal.backdrop.addEventListener('click', function(e) {
            if (e.target === this) {
                modal.close();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                modal.close();
            }
        });
    </script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toast.success('Berhasil', '{{ session('success') }}');
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toast.error('Error', '{{ session('error') }}');
        });
    </script>
    @endif

    @stack('scripts')
</body>
</html>
