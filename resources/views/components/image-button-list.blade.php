{{--
    $images => array // [['link', 'title', 'relative_url']]
    $class => string // 'image-button-list'
--}}
@if(!empty($class))<div class="{{ $class }}">@endif

@foreach($images as $image)
    <div class="my-4">
        @if(!empty($image['link']))<a href="{{ $image['link'] }}"@if(empty($image['relative_url'])) class="button expanded" @endif>@endif
            @if(!empty($image['relative_url']))
                @image($image['relative_url'], $image['title'], $class ?? '')
            @else
                {{ $image['title'] }}
            @endif
        @if(!empty($image['link']))</a>@endif
    </div>
@endforeach

@if(!empty($class))</div>@endif
