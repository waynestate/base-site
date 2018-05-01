{{--
    $banner => array // [['title','link', 'excerpt']]
    $class => string // 'banner'
--}}
<div class="banner">
    <a class="banner__container" href="{{ $banner['link'] }}">
        <span class="banner__text">{{ $banner['title'] }}</span>
        @if($banner['excerpt'] != '')
            <span class="banner__text--italic">{{ $banner['excerpt'] }}</span>
        @endif
    </a>
</div>
