{{--
    $button => array // [['title', 'link', 'excerpt']]
--}}

@if(!empty($button['excerpt']))
    <a href="{{ $button['link'] }}" class="button expanded text-left">
        <div class="block text-xl leading-tight">{{ $button['title'] }}</div>
        <div class="block pb-1 leading-tight">{{ $button['excerpt'] }}</div>
    </a>
@else
    <a href="{{ $button['link'] }}" class="button expanded">{{ $button['title'] }}</a>
@endif
