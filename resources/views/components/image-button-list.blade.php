{{--
    $images => array // [['link', 'title', 'relative_url']]
    $class => string // 'image-button-list'
--}}
@if(!empty($class))<div class="{{ $class }}">@endif

@foreach($images as $image)
    <div class="my-4 min-w-full">
        @if(!empty($image['link']))<a href="{{ $image['link'] }}" @if(empty($image['relative_url']))class="button expanded"@endif>@endif
            @if(!empty($image['relative_url']))
                @if($loop->first == true)
                    <img src="{{ $image['relative_url'] }}" alt="{{ $image['title'] }}" />
                @else
                    @image($image['relative_url'], $image['title'])
                @endif
            @else
                {{ $image['title'] }}
            @endif
        @if(!empty($image['link']))</a>@endif
    </div>
@endforeach

@if(!empty($class))</div>@endif
