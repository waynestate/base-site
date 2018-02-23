{{--
    $images => array // [['link', 'title', 'relative_url']]
    $class => string // 'under-menu'
--}}
@if(isset($class))<div class="{{ $class }}">@endif

@foreach($images as $image)
    <div>
        @if($image['link'] != '')<a href="{{ $image['link'] }}">@endif
            <img src="{{ $image['relative_url'] }}" alt="{{ $image['title'] }}" />
        @if($image['link'] != '')</a>@endif
    </div>
@endforeach

@if(isset($class))</div>@endif
