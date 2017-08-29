{{--
    $banner => array // [['title','link', 'excerpt']]
    $class => string // 'banner'
--}}
<div class="{{ $class }}">
    <a class="{{ $class }}__container" href="{{ $banner['link'] }}">
        <span class="{{ $class }}__text">{{ $banner['title'] }}</span>
        @if($banner['excerpt'] != '')
            <span class="{{ $class }}__text--italic">{{ $banner['excerpt'] }}</span>
        @endif
    </a>
</div>
