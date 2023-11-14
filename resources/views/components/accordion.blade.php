{{--
    $items => array // ['title', 'description']
--}}
<ul class="accordion">
    @foreach($data as $item)
        <li>
            <a href="#definition-{{ $item['promo_item_id'] }}" id="definition-{{ $item['promo_item_id'] }}"><span aria-hidden="true"></span>{{ $item['title'] }}</a>
            <div class="content">{!! $item['description'] !!}</div>
        </li>
    @endforeach
</ul>
