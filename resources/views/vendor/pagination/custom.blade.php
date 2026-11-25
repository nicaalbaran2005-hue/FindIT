@if ($paginator->hasPages())
<nav class="pager" role="navigation" aria-label="Pagination">

    <div class="pager-info">
        Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }}
        of {{ $paginator->total() }} results
    </div>

    <div class="pager-buttons">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="pager-btn disabled">
                <i class="ti ti-chevron-left"></i> Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pager-btn" rel="prev">
                <i class="ti ti-chevron-left"></i> Previous
            </a>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="pager-btn disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pager-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pager-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pager-btn" rel="next">
                Next <i class="ti ti-chevron-right"></i>
            </a>
        @else
            <span class="pager-btn disabled">
                Next <i class="ti ti-chevron-right"></i>
            </span>
        @endif

    </div>
</nav>

<style>
    .pager {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 12px; margin-top: 16px;
    }
    .pager-info { font-size: 12.5px; color: #64748b; }
    .pager-buttons { display: flex; align-items: center; gap: 6px; }
    .pager-btn {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 7px 13px; border-radius: 8px;
        font-size: 13px; font-weight: 500; font-family: 'Inter', sans-serif;
        background: #fff; color: #475569;
        border: 1px solid #e2e8f0; text-decoration: none;
        transition: all 0.15s;
    }
    a.pager-btn:hover { background: #EBF3FC; color: #185FA5; border-color: #185FA5; }
    .pager-btn.active { background: #185FA5; color: #fff; border-color: #185FA5; }
    .pager-btn.disabled { color: #cbd5e1; background: #f8fafc; cursor: not-allowed; }
</style>
@endif