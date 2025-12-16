@extends('admin.layouts.app')

@section('title', 'Detail Pesan')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.contacts.index') }}">Pesan Masuk</a>
    <span>/</span>
    <span>Detail</span>
@endsection

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1>Detail Pesan</h1>
        <p>Dari {{ $contact->name }} • {{ $contact->created_at->format('d M Y, H:i') }}</p>
    </div>
    <div style="display: flex; gap: 8px;">
        <form action="{{ route('admin.contacts.toggle-read', $contact) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-secondary">
                <i data-feather="{{ $contact->is_read ? 'mail' : 'mail-open' }}"></i>
                {{ $contact->is_read ? 'Tandai Belum Dibaca' : 'Tandai Sudah Dibaca' }}
            </button>
        </form>
        <button type="button" class="btn btn-danger" onclick="confirmDelete()">
            <i data-feather="trash-2"></i>
            Hapus
        </button>
    </div>
</div>

<div style="max-width: 800px;">
    <!-- Sender Info -->
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-header">
            <h3 class="card-title">Informasi Pengirim</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <div>
                    <label style="font-size: 12px; color: var(--color-gray-500); text-transform: uppercase; letter-spacing: 0.05em;">Nama</label>
                    <p style="font-weight: 500; color: var(--color-gray-800); margin: 4px 0 0;">{{ $contact->name }}</p>
                </div>
                <div>
                    <label style="font-size: 12px; color: var(--color-gray-500); text-transform: uppercase; letter-spacing: 0.05em;">Email</label>
                    <p style="margin: 4px 0 0;">
                        <a href="mailto:{{ $contact->email }}" style="color: var(--color-primary-600); text-decoration: none;">{{ $contact->email }}</a>
                    </p>
                </div>
                @if($contact->phone)
                <div>
                    <label style="font-size: 12px; color: var(--color-gray-500); text-transform: uppercase; letter-spacing: 0.05em;">Telepon</label>
                    <p style="margin: 4px 0 0;">
                        <a href="tel:{{ $contact->phone }}" style="color: var(--color-primary-600); text-decoration: none;">{{ $contact->phone }}</a>
                    </p>
                </div>
                @endif
                <div>
                    <label style="font-size: 12px; color: var(--color-gray-500); text-transform: uppercase; letter-spacing: 0.05em;">Waktu</label>
                    <p style="color: var(--color-gray-800); margin: 4px 0 0;">{{ $contact->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Content -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $contact->subject }}</h3>
        </div>
        <div class="card-body">
            <div style="white-space: pre-wrap; line-height: 1.7; color: var(--color-gray-700);">{{ $contact->message }}</div>
        </div>
        <div class="card-footer" style="display: flex; justify-content: space-between;">
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                <i data-feather="arrow-left"></i>
                Kembali
            </a>
            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn btn-primary">
                <i data-feather="reply"></i>
                Balas Email
            </a>
        </div>
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="deleteForm" action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function confirmDelete() {
    modal.confirm({
        title: 'Hapus Pesan?',
        message: 'Apakah Anda yakin ingin menghapus pesan ini? Tindakan ini tidak dapat dibatalkan.',
        type: 'danger',
        confirmText: 'Hapus',
        onConfirm: function() {
            document.getElementById('deleteForm').submit();
        }
    });
}
</script>
@endpush
