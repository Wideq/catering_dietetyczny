@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center" aria-label="Pagination">
        <ul class="pagination pagination-custom">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">‹</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">›</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">›</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

<style>
.pagination-custom {
    display: flex !important;
    list-style: none !important;
    padding: 0 !important;
    margin: 0 !important;
    border-radius: 12px !important;
    overflow: hidden !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    background: white !important;
    border: 1px solid #dee2e6 !important;
}

.pagination-custom .page-item {
    margin: 0 !important;
}

.pagination-custom .page-link {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 10px 15px !important;
    min-width: 44px !important;
    height: 44px !important;
    color: #495057 !important;
    background-color: #fff !important;
    border: 1px solid #dee2e6 !important;
    border-left: none !important;
    text-decoration: none !important;
    transition: all 0.3s ease !important;
    font-size: 14px !important;
    font-weight: 500 !important;
}

.pagination-custom .page-item:first-child .page-link {
    border-left: 1px solid #dee2e6 !important;
    border-top-left-radius: 12px !important;
    border-bottom-left-radius: 12px !important;
}

.pagination-custom .page-item:last-child .page-link {
    border-top-right-radius: 12px !important;
    border-bottom-right-radius: 12px !important;
}

.pagination-custom .page-link:hover {
    background: #007bff !important;
    color: white !important;
    border-color: #007bff !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 8px rgba(0,123,255,0.3) !important;
}

.pagination-custom .page-item.active .page-link {
    background: #007bff !important;
    border-color: #007bff !important;
    color: white !important;
    font-weight: 600 !important;
    box-shadow: 0 4px 8px rgba(0,123,255,0.3) !important;
    transform: translateY(-1px) !important;
}

.pagination-custom .page-item.disabled .page-link {
    color: #6c757d !important;
    background-color: #f8f9fa !important;
    border-color: #dee2e6 !important;
    cursor: not-allowed !important;
    opacity: 0.6 !important;
}

.pagination-custom .page-item.disabled .page-link:hover {
    transform: none !important;
    box-shadow: none !important;
    background-color: #f8f9fa !important;
    color: #6c757d !important;
}

@media (max-width: 768px) {
    .pagination-custom .page-link {
        padding: 8px 12px !important;
        min-width: 36px !important;
        height: 36px !important;
        font-size: 12px !important;
    }
}
</style>