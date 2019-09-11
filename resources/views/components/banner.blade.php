{{--
    $banner => array // [['title', 'link', 'excerpt']]
--}}
<div class="row relative">
    <a class="banner bg-yellow text-green-darker hover:text-green-darkest items-center justify-center absolute right-0 mr-4 transition transition-timing-ease-out hover:text-black hidden mt:flex z-40" href="{{ $banner['link'] }}">
        <span class="title uppercase text-sm tracking-wide">{{ $banner['title'] }}</span>
        @if($banner['excerpt'] != '')
            <span class="excerpt normal-case text-xl italic font-serif">{{ $banner['excerpt'] }}</span>
        @endif
    </a>
</div>
