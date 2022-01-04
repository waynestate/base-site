{{--
    $banner => array // [['title', 'link', 'excerpt']]
--}}
<div class="row relative">
    <a class="banner" href="{{ $banner['link'] }}">
        <span class="banner__title">{{ $banner['title'] }}</span>
        @if($banner['excerpt'] != '')
            <span class="banner__excerpt">{{ $banner['excerpt'] }}</span>
        @endif
    </a>
</div>
