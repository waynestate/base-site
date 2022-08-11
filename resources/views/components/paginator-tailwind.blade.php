@if ($paginator->hasPages())
    <div class="">
        <div>
            <p class="">
                {!! __('Showing') !!}
                @if ($paginator->firstItem())
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif

                {!! __('of') !!}
                <span class="font-medium">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        <div class="row">
            <span class="list-none">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="button">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="button">
                        {!! __('pagination.previous') !!}
                    </a>
                @endif
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span>
                            <span class="button">{{ $element }}</span>
                        </span>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page">
                                    <span class="button">{{ $page }}</span>
                                </span>
                            @else
                                <a href="{{ $url }}" class="button" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="button">
                        {!! __('pagination.next') !!}
                    </a>
                @else
                    <span class="">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </span>
        </div>
    </div>
@endif
