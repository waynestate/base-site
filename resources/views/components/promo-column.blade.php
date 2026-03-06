{{--
    $image_promo => single // ['title', 'link', 'filename_url', 'filename_alt_text']
--}}
@foreach($data as $item)
    @include('components/promo/item', ['class' => 'promo--grid-item'])
@endforeach
