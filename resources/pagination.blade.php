@if ($paginator->hasPages())
    <nav class="pagination-container" role="navigation" aria-label="Pagination Navigation">

        {{-- معلومات النتائج --}}
        <div class="pagination-info">
            عرض من
            <span class="pagination-info-strong">{{ $paginator->firstItem() }}</span>
            إلى
            <span class="pagination-info-strong">{{ $paginator->lastItem() }}</span>
            من أصل
            <span class="pagination-info-strong">{{ $paginator->total() }}</span>
            نتيجة
        </div>

        <ul class="pagination-list">
            {{-- رابط الصفحة السابقة --}}
            @if ($paginator->onFirstPage())
                <li class="pagination-item pagination-disabled" aria-disabled="true">
                    <span class="pagination-link">&laquo; السابق</span>
                </li>
            @else
                <li class="pagination-item">
                    <a class="pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; السابق</a>
                </li>
            @endif

            {{-- عناصر الترقيم --}}
            @foreach ($elements as $element)
                {{-- فاصل ثلاث نقاط --}}
                @if (is_string($element))
                    <li class="pagination-item pagination-disabled" aria-disabled="true">
                        <span class="pagination-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- روابط الصفحات --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination-item pagination-active" aria-current="page">
                                <span class="pagination-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="pagination-item">
                                <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- رابط الصفحة التالية --}}
            @if ($paginator->hasMorePages())
                <li class="pagination-item">
                    <a class="pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next">التالي &raquo;</a>
                </li>
            @else
                <li class="pagination-item pagination-disabled" aria-disabled="true">
                    <span class="pagination-link">التالي &raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
