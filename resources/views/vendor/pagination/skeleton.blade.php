@if ($paginator->hasPages())
    @php
        $total = $paginator->lastPage();
        $current = $paginator->currentPage();
        $start = max($current - 2, 1);
        $end = min($start + 4, $total);
        $start = max($end - 4, 1);
    @endphp

    <div class="pagination">
        {{-- Previous Button --}}
        @if ($paginator->onFirstPage())
            <span class="disabled">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">Previous</a>
        @endif

        {{-- Page Numbers --}}
        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $current)
                <span class="active">{{ $i }}</span>
            @else
                <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
            @endif
        @endfor

        {{-- Next Button --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">Next</a>
        @else
            <span class="disabled">Next</span>
        @endif
    </div>

    <style>
        .pagination { display: flex; justify-content: center; gap: 8px; margin-top: 30px; }
        .pagination a, .pagination span {
            padding: 8px 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }
        .pagination a:hover { background-color: #f0f0f0; }
        .pagination .disabled { color: #999; cursor: not-allowed; border-color: #eee; }
        .pagination .active { background-color: #333; color: #fff; border-color: #333; }
    </style>
@endif
