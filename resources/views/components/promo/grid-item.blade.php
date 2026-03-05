{{--
    This component's image is 1/4 width on small views
    $item => array // ['title', 'link', 'description', 'excerpt', 'relative_url', 'option']
--}}

<div @class([
     'promo',
     'promo--grid-item' => @empty($class),
     $class ?? '' => @empty(! $class),
     $component['promoItemClass'] ?? '' => @empty(! $component['promoItemClass']),
     'promo--image-small' => !empty($component['imageSize']) && $component['imageSize'] == "small",
     'promo--image-right' => !empty($component['imagePosition']) && $component['imagePosition'] == "right",
     'promo--image-alternate' => !empty($component['imagePosition']) && $component['imagePosition'] == "alternate",
     'promo--gradient-overlay' => !empty($component['gradientOverlay']) && $component['gradientOverlay'] == true])>

    @empty(! $item['relative_url'])
        <img data-src="{{ $item['relative_url'] }}" alt="{{ $item['filename_alt_text'] }}" 
        @class([
            "promo__image", 
            "lazy",
            "promo--play-button" => !empty($item['youtube_id'])
        ])>
    @endif

    <div class="promo__content">
        @if(!empty($item['title']))
            <div class="promo__title">
                @empty(! $item['link'])<a href="{{ $item['link'] }}" class="promo__link">@endif
                    {{ $item['title'] }}
                @empty(! $item['link'])<span class="promo__link-cover"></span></a>@endif
            </div>
        @endif

        @if(!empty($item['excerpt']))
            <p class="promo__excerpt">
                {!! strip_tags($item['excerpt'], ['em', 'strong', 'br', '&ldquo;', '&rdquo;']) !!}
            </p>
        @endif 

        @if(!empty($item['description']))
            <div class="promo__description content">
                {!! !empty($item['link']) ? preg_replace(['"<a href(.*?)>"', '"</a>"'], '', $item['description']) : $item['description'] !!}
            </div>
        @endif

        @if(!empty($component['gradientOverlay']) && $component['gradientOverlay'] == true)
            <div class="promo__gradient"></div>
        @endif
    </div>
</div>
