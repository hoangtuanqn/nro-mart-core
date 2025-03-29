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
            @php
                $window = 2; // Show 2 numbers on each side of current page
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                $start = max(1, $current - $window);
                $end = min($last, $current + $window);
            @endphp

            @if($start > 1)
                <a href="{{ $paginator->url(1) }}" class="pagination-item">1</a>
                @if($start > 2)
                    <a href="#" class="pagination-item disabled" aria-disabled="true">...</a>
                @endif
            @endif

            @for($i = $start; $i <= $end; $i++)
                @if($i == $current)
                    <a href="#" class="pagination-item active" aria-current="page">{{ $i }}</a>
                @else
                    <a href="{{ $paginator->url($i) }}" class="pagination-item">{{ $i }}</a>
                @endif
            @endfor

            @if($end < $last)
                @if($end < $last - 1)
                    <a href="#" class="pagination-item disabled" aria-disabled="true">...</a>
                @endif
                <a href="{{ $paginator->url($last) }}" class="pagination-item">{{ $last }}</a>
            @endif

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