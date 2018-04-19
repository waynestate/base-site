{{--
    $images => array // [['link', 'title', 'relative_url']]
    $class => string // 'image-button-list'
--}}
<div class="{{ $class ?? 'image-button-list' }}">

@foreach($images as $image)
    <div>
        @if(!empty($image['link']))<a href="{{ $image['link'] }}"@if(empty($image['relative_url'])) class="button expanded" @endif>@endif
            @if(!empty($image['relative_url']))
                @image($image['relative_url'], $image['title'], $class ?? '')
            @else
                {{ $image['title'] }}
            @endif
        @if(!empty($image['link']))</a>@endif
    </div>
@endforeach

</div>
