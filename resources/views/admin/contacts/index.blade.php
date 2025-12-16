@extends('admin.layouts.app')

@section('title', 'Pesan Masuk')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span>/</span>
    <span>Pesan Masuk</span>
@endsection

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1>Pesan Masuk</h1>
        <p>{{ $stats['unread'] }} pesan belum dibaca dari total {{ $stats['total'] }} pesan</p>
    </div>
    @if($stats['unread'] > 0)
        <form action="{{ route('admin.contacts.mark-all-read') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-secondary">
                <i data-feather="check-circle"></i>
                Tandai Semua Dibaca
            </button>
        </form>
    @endif
</div>

<!-- Filters -->
<div class="card" style="margin-bottom: 24px;">
    <div class="card-body" style="padding: 16px;">
        <form action="{{ route('admin.contacts.index') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="search" class="form-input" placeholder="Cari nama, email, atau subjek..." value="{{ request('search') }}">
            </div>
            <div style="min-width: 150px;">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                    <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">
                <i data-feather="search"></i>
                Filter
            </button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-ghost">Reset</a>
            @endif
        </form>
    </div>
</div>

<!-- Contacts List -->
<div class="card">
    <div class="card-body" style="padding: 0;">
        @if($contacts->count() > 0)
            <div class="contacts-list">
                @foreach($contacts as $contact)
                    <div class="contact-item {{ !$contact->is_read ? 'unread' : '' }}" style="display: flex; align-items: flex-start; gap: 16px; padding: 16px 20px; border-bottom: 1px solid var(--color-gray-100); transition: background 0.15s;">
                        <!-- Avatar -->
                        <div style="width: 48px; height: 48px; background: {{ !$contact->is_read ? 'var(--color-primary-100)' : 'var(--color-gray-100)' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i data-feather="user" style="width: 24px; height: 24px; color: {{ !$contact->is_read ? 'var(--color-primary-600)' : 'var(--color-gray-400)' }};"></i>
                        </div>

                        <!-- Content -->
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                <div>
                                    <span style="font-weight: {{ !$contact->is_read ? '600' : '400' }}; color: var(--color-gray-800);">
                                        {{ $contact->name }}
                                    </span>
                                    @if(!$contact->is_read)
                                        <span class="badge badge-success" style="margin-left: 8px;">Baru</span>
                                    @endif
                                </div>
                                <span style="font-size: 12px; color: var(--color-gray-400);">
                                    {{ $contact->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <div style="font-size: 14px; color: var(--color-gray-500); margin-bottom: 4px;">
                                {{ $contact->email }}
                                @if($contact->phone)
                                    • {{ $contact->phone }}
                                @endif
                            </div>
                            <div style="font-weight: {{ !$contact->is_read ? '500' : '400' }}; color: var(--color-gray-700); margin-bottom: 4px;">
                                {{ $contact->subject }}
                            </div>
                            <p style="font-size: 14px; color: var(--color-gray-500); margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ Str::limit($contact->message, 100) }}
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="table-actions" style="flex-shrink: 0;">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-ghost" title="Lihat">
                                <i data-feather="eye"></i>
                            </a>
                            <form action="{{ route('admin.contacts.toggle-read', $contact) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-ghost" title="{{ $contact->is_read ? 'Tandai Belum Dibaca' : 'Tandai Sudah Dibaca' }}">
                                    <i data-feather="{{ $contact->is_read ? 'mail' : 'mail-open' }}"></i>
                                </button>
                            </form>
                            <button type="button" class="btn btn-sm btn-ghost" onclick="confirmDelete({{ $contact->id }}, '{{ addslashes($contact->name) }}')" title="Hapus">
                                <i data-feather="trash-2"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($contacts->hasPages())
                <div class="card-footer">
                    {{ $contacts->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <i data-feather="mail" class="empty-state-icon"></i>
                <h3>Tidak ada pesan</h3>
                <p>Pesan dari pengunjung website akan muncul di sini</p>
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
        title: 'Hapus Pesan?',
        message: `Apakah Anda yakin ingin menghapus pesan dari "${name}"?`,
        type: 'danger',
        confirmText: 'Hapus',
        onConfirm: function() {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/contacts/${id}`;
            form.submit();
        }
    });
}
</script>
@endpush

@push('styles')
<style>
    .contact-item:hover {
        background: var(--color-gray-50);
    }

    .contact-item.unread {
        background: rgba(34, 197, 94, 0.03);
    }

    .contact-item.unread:hover {
        background: rgba(34, 197, 94, 0.06);
    }
</style>
@endpush
