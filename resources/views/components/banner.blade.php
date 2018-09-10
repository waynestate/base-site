{{--
    $banner => array // [['title','link', 'excerpt']]
    $class => string // 'banner'
--}}
<div class="row relative">
    <a class="banner bg-yellow items-center justify-center absolute pin-r mr-8 transition transition-timing-ease-out hover:text-black hidden mt:flex z-10" href="{{ $banner['link'] }}">
        <span class="title uppercase text-sm tracking-wide">{{ $banner['title'] }}</span>
        @if($banner['excerpt'] != '')
            <span class="excerpt normal-case text-xl italic font-serif">{{ $banner['excerpt'] }}</span>
        @endif
    </a>
</div>
