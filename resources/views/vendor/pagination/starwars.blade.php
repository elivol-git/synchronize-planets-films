@if ($paginator->hasPages())
    <nav class="sw-pagination">
        {{-- PREVIOUS --}}
        @if ($paginator->onFirstPage())
            <span class="sw-page disabled">«</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="sw-page">«</a>
        @endif

        {{-- PAGE NUMBERS --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" --}}
            @if (is_string($element))
                <span class="sw-dots">{{ $element }}</span>
            @endif

            {{-- Page Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="sw-page active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="sw-page">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- NEXT --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="sw-page">»</a>
        @else
            <span class="sw-page disabled">»</span>
        @endif
    </nav>
@endif
