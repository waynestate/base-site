{{--
    $data => array // ['title', 'excerpt', 'description', 'link', 'filename_url', 'filename_alt_text']
--}}

<div class="catalog">
    <div class="catalog__flex {{ $component['catalogClass'] ?? 'gap-y-8 gap-x-6 mt-6' }}">
        @foreach($data as $item)
            @include('components/promo/grid-item', [$component['promoItemClass'] = !empty($component['promoItemClass']) ? $component['promoItemClass'] : 'w-1/2 lg:w-1/4'])
        @endforeach
    </div>
</div>
