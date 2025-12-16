@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="pagination-btn disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <i data-feather="chevron-left" style="width: 16px; height: 16px;"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn" rel="prev" aria-label="@lang('pagination.previous')">
                <i data-feather="chevron-left" style="width: 16px; height: 16px;"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="pagination-btn disabled" aria-disabled="true">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pagination-btn active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn" rel="next" aria-label="@lang('pagination.next')">
                <i data-feather="chevron-right" style="width: 16px; height: 16px;"></i>
            </a>
        @else
            <span class="pagination-btn disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <i data-feather="chevron-right" style="width: 16px; height: 16px;"></i>
            </span>
        @endif
    </div>
@endif
