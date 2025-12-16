@extends('admin.layouts.app')

@section('title', 'Kategori')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span>/</span>
    <span>Kategori</span>
@endsection

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: flex-start;">
    <div>
        <h1>Kategori</h1>
        <p>Kelola kategori produk Anda</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i data-feather="plus"></i>
        Tambah Kategori
    </a>
</div>

<!-- Filters -->
<div class="card" style="margin-bottom: 24px;">
    <div class="card-body" style="padding: 16px;">
        <form action="{{ route('admin.categories.index') }}" method="GET" style="display: flex; gap: 16px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="search" class="form-input" placeholder="Cari kategori..." value="{{ request('search') }}">
            </div>
            <div>
                <select name="status" class="form-select" style="min-width: 150px;">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">
                <i data-feather="search"></i>
                Filter
            </button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">Reset</a>
            @endif
        </form>
    </div>
</div>

<!-- Categories Table -->
<div class="card">
    <div class="card-body" style="padding: 0;">
        @if($categories->count() > 0)
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Icon</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th style="text-align: center;">Produk</th>
                            <th style="text-align: center;">Status</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}"
                                         alt="{{ $category->name }}"
                                         style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                                @elseif($category->icon)
                                    <div style="width: 40px; height: 40px; background: var(--color-primary-100); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                        {{ $category->icon }}
                                    </div>
                                @else
                                    <div style="width: 40px; height: 40px; background: var(--color-gray-100); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i data-feather="folder" style="width: 20px; height: 20px; color: var(--color-gray-400);"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span style="font-weight: 500;">{{ $category->name }}</span>
                            </td>
                            <td>
                                <span style="color: var(--color-gray-500); font-size: 14px;">
                                    {{ Str::limit($category->description, 50) ?? '-' }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <span class="badge badge-info">{{ $category->products_count }}</span>
                            </td>
                            <td style="text-align: center;">
                                @if($category->is_active)
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
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-ghost" title="Edit">
                                        <i data-feather="edit-2"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-ghost" title="{{ $category->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i data-feather="{{ $category->is_active ? 'eye-off' : 'eye' }}"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-ghost"
                                            onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}', {{ $category->products_count }})"
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

            @if($categories->hasPages())
                <div class="card-footer">
                    {{ $categories->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <i data-feather="folder" class="empty-state-icon"></i>
                <h3>Belum ada kategori</h3>
                <p>Mulai dengan menambahkan kategori pertama</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary" style="margin-top: 16px;">
                    <i data-feather="plus"></i>
                    Tambah Kategori
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
function confirmDelete(id, name, productCount) {
    if (productCount > 0) {
        modal.alert(
            'Tidak Dapat Dihapus',
            `Kategori "${name}" masih memiliki ${productCount} produk. Pindahkan atau hapus produk terlebih dahulu.`,
            'warning'
        );
        return;
    }

    modal.confirm({
        title: 'Hapus Kategori?',
        message: `Apakah Anda yakin ingin menghapus kategori "${name}"? Tindakan ini tidak dapat dibatalkan.`,
        type: 'danger',
        confirmText: 'Hapus',
        onConfirm: function() {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/categories/${id}`;
            form.submit();
        }
    });
}
</script>
@endpush
