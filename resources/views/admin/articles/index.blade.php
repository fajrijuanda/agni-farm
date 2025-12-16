@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Daftar Artikel</h6>
                <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-sm mb-0">
                    <i class="fas fa-plus me-2"></i>Tambah Artikel
                </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Artikel</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $article)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ $article->image_url }}" class="avatar avatar-sm me-3" alt="article">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ Str::limit($article->title, 40) }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ Str::limit($article->excerpt ?? $article->content, 50) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($article->is_published)
                                        <span class="badge badge-sm bg-gradient-success">Published</span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-secondary">Draft</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $article->created_at->format('d/m/Y') }}</span>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit article">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="d-inline-block ms-2" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger text-xs font-weight-bold p-0 m-0 border-0 bg-transparent">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <p class="text-sm text-secondary mb-0">Belum ada artikel.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
