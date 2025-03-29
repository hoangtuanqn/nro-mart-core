@if ($paginator->hasPages())
    <nav>
        <div class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a href="#" class="pagination-item" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <i class="fa-solid fa-angle-left"></i>
                </a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-item" rel="prev"
                    aria-label="@lang('pagination.previous')">
                    <i class="fa-solid fa-angle-left"></i>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <a href="#" class="pagination-item disabled" aria-disabled="true">{{ $element }}</a>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a href="#" class="pagination-item active" aria-current="page">{{ $page }}</a>
                        @else
                            <a href="{{ $url }}" class="pagination-item">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-item next" rel="next"
                    aria-label="@lang('pagination.next')">
                    <i class="fa-solid fa-angle-right"></i>
                </a>
            @else
                <a href="#" class="pagination-item next" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <i class="fa-solid fa-angle-right"></i>
                </a>
            @endif
        </div>
    </nav>
@endif