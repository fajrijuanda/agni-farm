@extends('admin.layouts.app')

@section('title', 'Catalog Produk')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span>/</span>
    <span>Catalog</span>
@endsection

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1>Catalog Produk</h1>
        <p>Kelola semua produk Anda</p>
    </div>
    <a href="{{ route('admin.catalog.create') }}" class="btn btn-primary">
        <i data-feather="plus"></i>
        Tambah Produk
    </a>
</div>

<!-- Filters -->
<div class="card" style="margin-bottom: 24px;">
    <div class="card-body" style="padding: 16px;">
        <form action="{{ route('admin.catalog.index') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="search" class="form-input" placeholder="Cari produk..." value="{{ request('search') }}">
            </div>
            <div style="min-width: 150px;">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="min-width: 130px;">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div style="min-width: 130px;">
                <select name="featured" class="form-select">
                    <option value="">Featured</option>
                    <option value="yes" {{ request('featured') === 'yes' ? 'selected' : '' }}>Ya</option>
                    <option value="no" {{ request('featured') === 'no' ? 'selected' : '' }}>Tidak</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">
                <i data-feather="search"></i>
                Filter
            </button>
            @if(request()->hasAny(['search', 'category', 'status', 'featured']))
                <a href="{{ route('admin.catalog.index') }}" class="btn btn-ghost">Reset</a>
            @endif
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="card">
    <div class="card-body" style="padding: 0;">
        @if($products->count() > 0)
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Foto</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th style="text-align: center;">Featured</th>
                            <th style="text-align: center;">Status</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                @if($product->primary_image)
                                    <img src="{{ asset('storage/' . $product->primary_image->image_path) }}"
                                         alt="{{ $product->name }}"
                                         style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;">
                                @else
                                    <div style="width: 60px; height: 60px; background: var(--color-gray-100); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i data-feather="image" style="width: 24px; height: 24px; color: var(--color-gray-400);"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <span style="font-weight: 500; display: block;">{{ $product->name }}</span>
                                    <span style="font-size: 12px; color: var(--color-gray-500);">
                                        {{ Str::limit($product->short_description, 40) }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $product->category->name ?? '-' }}</span>
                            </td>
                            <td>
                                @if($product->has_discount)
                                    <div>
                                        <span style="text-decoration: line-through; color: var(--color-gray-400); font-size: 12px;">
                                            {{ $product->formatted_price }}
                                        </span>
                                        <br>
                                        <span style="font-weight: 600; color: var(--color-secondary-600);">
                                            {{ $product->formatted_discount_price }}
                                        </span>
                                        <span class="badge badge-warning" style="margin-left: 4px;">
                                            -{{ $product->discount_percentage }}%
                                        </span>
                                    </div>
                                @else
                                    <span style="font-weight: 500;">{{ $product->formatted_price }}</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <form action="{{ route('admin.catalog.toggle-featured', $product) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-ghost" title="Toggle Featured">
                                        @if($product->is_featured)
                                            <i data-feather="star" style="fill: var(--color-warning); color: var(--color-warning);"></i>
                                        @else
                                            <i data-feather="star" style="color: var(--color-gray-300);"></i>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td style="text-align: center;">
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
                            <td>
                                <div class="table-actions">
                                    <a href="{{ $product->shopee_link }}" target="_blank" class="btn btn-sm btn-ghost" title="Lihat di Shopee">
                                        <i data-feather="external-link"></i>
                                    </a>
                                    <a href="{{ route('admin.catalog.edit', $product) }}" class="btn btn-sm btn-ghost" title="Edit">
                                        <i data-feather="edit-2"></i>
                                    </a>
                                    <form action="{{ route('admin.catalog.duplicate', $product) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-ghost" title="Duplikat">
                                            <i data-feather="copy"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.catalog.toggle-status', $product) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-ghost" title="{{ $product->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i data-feather="{{ $product->is_active ? 'eye-off' : 'eye' }}"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-ghost"
                                            onclick="confirmDelete({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                            title="Hapus">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="card-footer">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <i data-feather="package" class="empty-state-icon"></i>
                <h3>Belum ada produk</h3>
                <p>Mulai dengan menambahkan produk pertama ke catalog</p>
                <a href="{{ route('admin.catalog.create') }}" class="btn btn-primary" style="margin-top: 16px;">
                    <i data-feather="plus"></i>
                    Tambah Produk
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="deleteForm" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    modal.confirm({
        title: 'Hapus Produk?',
        message: `Apakah Anda yakin ingin menghapus produk "${name}"? Semua foto dan data produk akan dihapus permanen.`,
        type: 'danger',
        confirmText: 'Hapus',
        onConfirm: function() {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/catalog/${id}`;
            form.submit();
        }
    });
}
</script>
@endpush

@push('styles')
<style>
    @media (max-width: 768px) {
        .table-actions {
            flex-wrap: wrap;
        }
    }
</style>
@endpush
