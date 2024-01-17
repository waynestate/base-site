{{--
    This component's image is full width on small views
    $image_promo => single // ['title', 'link', 'filename_url', 'filename_alt_text']
--}}
@foreach($data as $item)
    @include('components/promo/grid-item')
@endforeach
