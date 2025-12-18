@props(['article'])

<article class="article-card">
    <a href="{{ route('articles.show', $article) }}" class="article-card-image">
        @if($article->image)
            <img src="{{ $article->image_url }}" alt="{{ $article->title }}">
        @else
            <div class="article-card-placeholder">
                <i data-feather="file-text"></i>
            </div>
        @endif
        <div class="article-card-overlay">
            <span class="article-read-more">Baca Artikel</span>
        </div>
    </a>
    <div class="article-card-body">
        <div class="article-meta">
            <span class="article-date">
                <i data-feather="calendar"></i>
                {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
            </span>
            <span class="article-views">
                <i data-feather="eye"></i>
                {{ number_format($article->views) }}
            </span>
        </div>
        @if($article->youtube_url)
        <span class="article-video-badge">
            <i data-feather="play-circle"></i>
            Video
        </span>
        @endif
        <h3 class="article-card-title">
            <a href="{{ route('articles.show', $article) }}">{{ Str::limit($article->title, 60) }}</a>
        </h3>
        <p class="article-card-excerpt">
            {{ Str::limit($article->excerpt ?? strip_tags($article->content), 100) }}
        </p>
        <a href="{{ route('articles.show', $article) }}" class="article-link">
            Baca Selengkapnya
            <i data-feather="arrow-right"></i>
        </a>
    </div>
</article>
