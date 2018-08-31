{{--
    $images => array // [['link', 'title', 'relative_url']]
    $class => string // 'image-button-list'
--}}
@if(!empty($class))<div class="{{ $class }}">@endif

@foreach($images as $image)
    <div class="min-w-full{{ empty($class) ? ' my-4' : '' }}">
        @if(!empty($image['link']))<a href="{{ $image['link'] }}" @if(empty($image['relative_url']))class="button expanded"@endif>@endif
            @if(!empty($image['relative_url']))
                @if($loop->first == true)
                    <img class="min-w-full" src="{{ $image['relative_url'] }}" alt="{{ $image['title'] }}" />
                @else
                    @image($image['relative_url'], $image['title'])
                @endif
            @elseif(!empty($image['relative_url']) && !empty($image['secondary_image']))
                <img src="/promos/{{ $image['promo_group_id'] }}/{{ $image['secondary_image']}}">
                true
            @else
                {{ $image['title'] }}
            @endif
        @if(!empty($image['link']))</a>@endif
    </div>
@endforeach

@if(!empty($class))</div>@endif
