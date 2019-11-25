{{--
    $featured_promo => array // ['link', 'title', 'relative_url', 'excerpt']
--}}

@if(!empty($featured_promo['link']))<a class="group" href="{{ $featured_promo['link'] }}">@endif
    @image($featured_promo['relative_url'], $featured_promo['filename_alt_text'], 'min-w-full mt-2')
    <p class="font-bold no-underline group-hover:underline pt-2">{{ $featured_promo['title'] }}</p>
@if(!empty($featured_promo['link']))</a>@endif
