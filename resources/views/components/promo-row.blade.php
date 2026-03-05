{{--
    $item => single // ['title', 'excerpt', 'description', 'link', 'relative_url', 'filename_alt_text']
--}}
@foreach($data as $item)
    @include('components/promo/item', ['class' => 'promo--list-item'])
@endforeach
