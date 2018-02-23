{{--
    $images => array // [['link', 'title', 'relative_url']]
    $class => string // 'rotate'
--}}
@if(isset($class))<div class="{{ $class }}">@endif

@foreach($images as $image)
    <div>
        @if($image['link'] != '')<a href="{{ $image['link'] }}">@endif
        @if($image == current($images))
            <img src="{{ $image['relative_url'] }}" alt="{{ $image['title'] }}" />
        @else
            <img class="b-lazy" src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==
                data-src="{{ $image['relative_url'] }}" alt="{{ $image['title'] }}" />
        @endif
        @if($image['link'] != '')</a>@endif
    </div>
@endforeach

@if(isset($class))</div>@endif
