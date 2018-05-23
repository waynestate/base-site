{{--
    $banner => array // [['title','link', 'excerpt']]
    $class => string // 'banner'
--}}
<div class="banner">
    <a class="hover:text-black" href="{{ $banner['link'] }}">
        <span class="title">{{ $banner['title'] }}</span>
        @if($banner['excerpt'] != '')
            <span class="excerpt">{{ $banner['excerpt'] }}</span>
        @endif
    </a>
</div>
