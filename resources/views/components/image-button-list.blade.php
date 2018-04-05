{{--
    $images => array // [['link', 'title', 'relative_url']]
    $class => string // 'under-menu'
--}}
@if(isset($class))<div class="{{ $class }}">@endif

@foreach($images as $image)
    <div>
        @if(!empty($image['link']))<a href="{{ $image['link'] }}"@if(empty($image['relative_url'])) class="button expanded" @endif>@endif
            @if(!empty($image['relative_url']))
                <img src="{{ $image['relative_url'] }}" alt="{{ $image['title'] }}" />
            @else
                {{ $image['title'] }}
            @endif
        @if(!empty($image['link']))</a>@endif
    </div>
@endforeach

@if(isset($class))</div>@endif
