{{--
    This component's image is full width on small views
    $image_promo => single // ['title', 'link', 'filename_url', 'filename_alt_text']
--}}
@foreach($data as $item)
    @if(!empty($component['gradientOverlay']) && $component['gradientOverlay'] === true)
        @include('components/promo-grid-item-gradient-overlay')
    @else
        @include('components/promo-grid-item')
    @endif
@endforeach
