@extends('layouts.app')

@section('title', $article->title . ' | Agni Farm')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-primary text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('articles.index') }}" class="text-primary text-decoration-none">Artikel</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($article->title, 20) }}</li>
                </ol>
            </nav>

            <h1 class="display-5 font-weight-bold mb-3">{{ $article->title }}</h1>

            <div class="d-flex align-items-center text-muted mb-4">
                <div class="d-flex align-items-center me-4">
                    <i class="feather-calendar me-2" style="width: 16px;"></i>
                    <span>{{ $article->published_at ? $article->published_at->format('d F Y') : $article->created_at->format('d F Y') }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="feather-user me-2" style="width: 16px;"></i>
                    <span>{{ $article->user->name ?? 'Admin' }}</span>
                </div>
            </div>

            @if($article->image)
            <div class="mb-5 rounded-lg overflow-hidden shadow-sm">
                <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="img-fluid w-100">
            </div>
            @endif

            <div class="article-content" style="line-height: 1.8; font-size: 1.1rem; color: #4a5568;">
                {!! nl2br(e($article->content)) !!}
            </div>

            <hr class="my-5">

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('articles.index') }}" class="btn btn-outline-primary">
                    <i class="feather-arrow-left me-2"></i> Kembali ke Artikel
                </a>

                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-sm btn-icon btn-secondary rounded-circle" aria-label="Share on Facebook">
                        <i class="feather-facebook" style="width: 16px;"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-icon btn-secondary rounded-circle" aria-label="Share on Twitter">
                        <i class="feather-twitter" style="width: 16px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
