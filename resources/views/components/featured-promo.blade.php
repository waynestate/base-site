{{--
    $featured_promo => array // ['link', 'title', 'relative_url', 'excerpt']
--}}

@if(!empty($featured_promo['link']))<a href="{{ $featured_promo['link'] }}">@endif
    @image($featured_promo['relative_url'], $featured_promo['excerpt'], 'min-w-full mt-2')
    <p class="font-bold hover:underline p-4 -mt-2 text-white bg-green">{{ $featured_promo['title'] }}</p>
@if(!empty($featured_promo['link']))</a>@endif
