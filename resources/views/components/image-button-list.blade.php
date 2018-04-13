{{--
    $images => array // [['link', 'title', 'relative_url']]
    $class => string // 'image-button-list'
--}}
<div class="{{ $class ?? 'image-button-list' }}">

@foreach($images as $image)
    {{-- <div style="max-width:100%; position:relative;"> --}}
    <div>
        @if(!empty($image['link']))<a href="{{ $image['link'] }}"@if(empty($image['relative_url'])) class="button expanded" @endif>@endif
            @if(!empty($image['relative_url']))
                {{-- Normal --}}
                {{-- <img src="{{ $image['relative_url'] }}" alt="{{ $image['title'] }}" /> --}}

                {{-- Lazy Loading working (but not the right ones) --}}
                {{-- <img class="lazy" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="{{ $image['relative_url'] }}" alt="{{ $image['title'] }}" /> --}}

                {{-- Example showing why the above isn't working properly --}}
                {{-- <img  alt="{{ $image['title'] }}" /> --}}

                {{-- Forcing the width to be 100% of the container does calculate the height correctly (not sure how), but we might not always want it to be 100% --}}
                <img style="min-width: 100%;" class="lazy" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="{{ $image['relative_url'] }}" alt="{{ $image['title'] }}" />

                {{-- Requires the containing div to have style. Calculate the height based on the aspect ratio: seems like the above example is better --}}
                {{-- <img style="position:absolute; width:100%; height:100%;" class="lazy" data-aspect="0.36" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="{{ $image['relative_url'] }}" alt="{{ $image['title'] }}" /> --}}
           
                {{-- Have not tried to do background images yet, not sure what we will run into with that doing the 100% width method --}}
            @else
                {{ $image['title'] }}
            @endif
        @if(!empty($image['link']))</a>@endif
    </div>
@endforeach

</div>
