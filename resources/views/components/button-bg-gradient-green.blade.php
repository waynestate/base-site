{{--
    $button => array // [['title', 'link', 'excerpt']]
--}}

@if(!empty($button['excerpt']))
    <a href="{{ $button['link'] }}" class="button expanded bg-gradient-green text-white text-left">
        <div class="block text-xl leading-tight">{{ $button['title'] }}</div>
        <div class="block pb-1 leading-tight">{{ $button['excerpt'] }}</div>
    </a>
@else
    <a href="{{ $button['link'] }}" class="button expanded bg-gradient-green text-white">{{ $button['title'] }}</a>
@endif
