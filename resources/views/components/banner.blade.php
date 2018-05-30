{{--
    $banner => array // [['title','link', 'excerpt']]
    $class => string // 'banner'
--}}
<a class="banner bg-yellow items-center justify-center absolute pin-r mr-16 transition transition-timing-ease-out hover:text-black hidden mt:flex " href="{{ $banner['link'] }}">
    <span class="title uppercase text-sm tracking-wide">{{ $banner['title'] }}</span>
    @if($banner['excerpt'] != '')
        <span class="excerpt normal-case text-xl italic font-serif">{{ $banner['excerpt'] }}</span>
    @endif
</a>
