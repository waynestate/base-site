{{--
    $button => array // ['title', 'link', 'excerpt']
--}}

@if(!empty($button['excerpt']))
    <a href="{{ $button['link'] }}" class="button-bg-image-dark button expanded bg-gradient-green text-white text-left">
        <div class="block text-lg xl:text-xl leading-tight">{{ $button['title'] }}</div>
        <div class="text-sm pb-1 leading-tight font-normal">{{ $button['excerpt'] }}</div>
    </a>
@else
    <a href="{{ $button['link'] }}" class="button expanded bg-gradient-green text-white">{{ $button['title'] }}</a>
@endif
