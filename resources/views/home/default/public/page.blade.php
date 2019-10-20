@if ($paginator->hasPages())
    <div id="pageGro" class="cb">
        <div class="pageUp"><a @if (!$paginator->onFirstPage())href="{{ $paginator->previousPageUrl() }}"@endif></a></div>
        <div class="pageList">
            <ul>
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="disabled" aria-disabled="true"><a>{{ $element }}</a></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <li><a href="{{ $url }}"  @if ($page == $paginator->currentPage())class="on"@endif>{{ $page }}</a></li>
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="pageDown"><a @if ($paginator->hasMorePages())href="{{ $paginator->nextPageUrl() }}"@endif></a></div>
    </div>
@endif
