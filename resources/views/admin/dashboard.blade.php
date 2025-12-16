@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <span>Dashboard</span>
@endsection

@section('content')
<div class="page-header">
    <h1>Dashboard</h1>
    <p>Selamat datang kembali, {{ auth()->user()->name }}! 👋</p>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 32px;">
    <div class="stat-card">
        <div class="stat-card-icon primary">
            <i data-feather="package"></i>
        </div>
        <div class="stat-card-content">
            <h3>{{ $stats['total_products'] }}</h3>
            <p>Total Produk</p>
            <span class="stat-card-change positive">{{ $stats['active_products'] }} aktif</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon secondary">
            <i data-feather="folder"></i>
        </div>
        <div class="stat-card-content">
            <h3>{{ $stats['total_categories'] }}</h3>
            <p>Kategori</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon info">
            <i data-feather="eye"></i>
        </div>
        <div class="stat-card-content">
            <h3>{{ number_format($stats['total_views']) }}</h3>
            <p>Total Views</p>
            <span class="stat-card-change positive">+{{ $stats['today_views'] }} hari ini</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon warning">
            <i data-feather="mail"></i>
        </div>
        <div class="stat-card-content">
            <h3>{{ $stats['total_contacts'] }}</h3>
            <p>Pesan Masuk</p>
            @if($stats['unread_contacts'] > 0)
                <span class="stat-card-change" style="color: var(--color-warning);">{{ $stats['unread_contacts'] }} belum dibaca</span>
            @endif
        </div>
    </div>
</div>

<!-- Visitor Statistics -->
<div class="card" style="margin-bottom: 32px;">
    <div class="card-header">
        <h3 class="card-title">📊 Statistik Pengunjung</h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
            <!-- Chart -->
            <div>
                <h4 style="font-size: 14px; color: var(--color-gray-600); margin-bottom: 16px;">Views 7 Hari Terakhir</h4>
                <div style="display: flex; align-items: flex-end; gap: 8px; height: 150px;">
                    @php
                        $maxViews = max(array_column($dailyViews, 'views')) ?: 1;
                    @endphp
                    @foreach($dailyViews as $day)
                        @php
                            $height = ($day['views'] / $maxViews) * 100;
                        @endphp
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                            <span style="font-size: 11px; color: var(--color-gray-600); margin-bottom: 4px;">{{ $day['views'] }}</span>
                            <div style="width: 100%; height: {{ max($height, 5) }}%; background: linear-gradient(180deg, var(--color-primary-400) 0%, var(--color-primary-600) 100%); border-radius: 4px 4px 0 0; min-height: 5px;"></div>
                            <span style="font-size: 10px; color: var(--color-gray-500); margin-top: 8px;">{{ $day['date'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Summary -->
            <div>
                <h4 style="font-size: 14px; color: var(--color-gray-600); margin-bottom: 16px;">Ringkasan</h4>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div style="display: flex; justify-content: space-between; padding: 12px; background: var(--color-gray-50); border-radius: 8px;">
                        <span style="color: var(--color-gray-600);">Hari Ini</span>
                        <span style="font-weight: 600; color: var(--color-primary-600);">{{ number_format($stats['today_views']) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 12px; background: var(--color-gray-50); border-radius: 8px;">
                        <span style="color: var(--color-gray-600);">Minggu Ini</span>
                        <span style="font-weight: 600; color: var(--color-gray-800);">{{ number_format($stats['week_views']) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 12px; background: var(--color-gray-50); border-radius: 8px;">
                        <span style="color: var(--color-gray-600);">Bulan Ini</span>
                        <span style="font-weight: 600; color: var(--color-gray-800);">{{ number_format($stats['month_views']) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Per Page Stats -->
        <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--color-gray-200);">
            <h4 style="font-size: 14px; color: var(--color-gray-600); margin-bottom: 16px;">Views per Halaman</h4>
            <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px;">
                <div style="text-align: center; padding: 16px; background: var(--color-gray-50); border-radius: 8px;">
                    <i data-feather="home" style="width: 20px; height: 20px; color: var(--color-primary-500); margin-bottom: 8px;"></i>
                    <p style="font-size: 18px; font-weight: 700; color: var(--color-gray-800); margin: 0;">{{ number_format($stats['home_views']) }}</p>
                    <span style="font-size: 12px; color: var(--color-gray-500);">Home</span>
                </div>
                <div style="text-align: center; padding: 16px; background: var(--color-gray-50); border-radius: 8px;">
                    <i data-feather="grid" style="width: 20px; height: 20px; color: var(--color-secondary-500); margin-bottom: 8px;"></i>
                    <p style="font-size: 18px; font-weight: 700; color: var(--color-gray-800); margin: 0;">{{ number_format($stats['catalog_views']) }}</p>
                    <span style="font-size: 12px; color: var(--color-gray-500);">Catalog</span>
                </div>
                <div style="text-align: center; padding: 16px; background: var(--color-gray-50); border-radius: 8px;">
                    <i data-feather="package" style="width: 20px; height: 20px; color: var(--color-info); margin-bottom: 8px;"></i>
                    <p style="font-size: 18px; font-weight: 700; color: var(--color-gray-800); margin: 0;">{{ number_format($stats['product_views']) }}</p>
                    <span style="font-size: 12px; color: var(--color-gray-500);">Produk</span>
                </div>
                <div style="text-align: center; padding: 16px; background: var(--color-gray-50); border-radius: 8px;">
                    <i data-feather="info" style="width: 20px; height: 20px; color: var(--color-warning); margin-bottom: 8px;"></i>
                    <p style="font-size: 18px; font-weight: 700; color: var(--color-gray-800); margin: 0;">{{ number_format($stats['about_views']) }}</p>
                    <span style="font-size: 12px; color: var(--color-gray-500);">About</span>
                </div>
                <div style="text-align: center; padding: 16px; background: var(--color-gray-50); border-radius: 8px;">
                    <i data-feather="mail" style="width: 20px; height: 20px; color: var(--color-success); margin-bottom: 8px;"></i>
                    <p style="font-size: 18px; font-weight: 700; color: var(--color-gray-800); margin: 0;">{{ number_format($stats['contact_views']) }}</p>
                    <span style="font-size: 12px; color: var(--color-gray-500);">Contact</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Grid -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Recent Products -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Produk Terbaru</h3>
            <a href="#" class="btn btn-sm btn-secondary">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding: 0;">
            @if($recentProducts->count() > 0)
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentProducts as $product)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; background: var(--color-gray-100); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                            <i data-feather="image" style="width: 20px; height: 20px; color: var(--color-gray-400);"></i>
                                        </div>
                                        <span style="font-weight: 500;">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $product->category->name ?? '-' }}</span>
                                </td>
                                <td>{{ $product->formatted_price }}</td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge badge-success">
                                            <span class="status-dot active"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            <span class="status-dot inactive"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state" style="padding: 60px 20px;">
                    <i data-feather="package" class="empty-state-icon"></i>
                    <h3>Belum ada produk</h3>
                    <p>Mulai tambahkan produk pertama Anda ke catalog</p>
                    <a href="#" class="btn btn-primary" style="margin-top: 16px;">
                        <i data-feather="plus"></i>
                        Tambah Produk
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Contacts -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pesan Terbaru</h3>
            <a href="#" class="btn btn-sm btn-secondary">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding: 0;">
            @if($recentContacts->count() > 0)
                <div style="padding: 0;">
                    @foreach($recentContacts as $contact)
                    <div style="padding: 16px 20px; border-bottom: 1px solid var(--color-gray-100); display: flex; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: {{ $contact->is_read ? 'var(--color-gray-100)' : 'var(--color-primary-100)' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i data-feather="user" style="width: 20px; height: 20px; color: {{ $contact->is_read ? 'var(--color-gray-400)' : 'var(--color-primary-600)' }};"></i>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                <span style="font-weight: {{ $contact->is_read ? '400' : '600' }}; color: var(--color-gray-800); font-size: 14px;">{{ $contact->name }}</span>
                                <span style="font-size: 12px; color: var(--color-gray-400);">{{ $contact->created_at->diffForHumans() }}</span>
                            </div>
                            <p style="font-size: 13px; color: var(--color-gray-600); margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $contact->subject }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state" style="padding: 40px 20px;">
                    <i data-feather="mail" class="empty-state-icon" style="width: 48px; height: 48px;"></i>
                    <h3>Belum ada pesan</h3>
                    <p>Pesan dari pengunjung akan muncul di sini</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Popular Products -->
<div class="card" style="margin-top: 24px;">
    <div class="card-header">
        <h3 class="card-title">Produk Populer</h3>
    </div>
    <div class="card-body" style="padding: 0;">
        @if($popularProducts->count() > 0)
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Views</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($popularProducts as $index => $product)
                        <tr>
                            <td>
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; background: {{ $index < 3 ? 'var(--color-primary-100)' : 'var(--color-gray-100)' }}; color: {{ $index < 3 ? 'var(--color-primary-700)' : 'var(--color-gray-600)' }}; border-radius: 50%; font-size: 12px; font-weight: 600;">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <span style="font-weight: 500;">{{ $product->name }}</span>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $product->category->name ?? '-' }}</span>
                            </td>
                            <td>
                                <span style="display: flex; align-items: center; gap: 4px;">
                                    <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                                    {{ number_format($product->view_count) }}
                                </span>
                            </td>
                            <td>{{ $product->formatted_price }}</td>
                            <td>
                                <a href="{{ $product->shopee_link }}" target="_blank" class="btn btn-sm btn-secondary">
                                    <i data-feather="external-link"></i>
                                    Shopee
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state" style="padding: 60px 20px;">
                <i data-feather="trending-up" class="empty-state-icon"></i>
                <h3>Belum ada data</h3>
                <p>Statistik produk populer akan muncul setelah ada pengunjung</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    @@media (max-width: 1024px) {
        [style*="grid-template-columns: 2fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush
