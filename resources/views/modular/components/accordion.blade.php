{{--
    $item => array // ['title', 'description']
--}}
<div class="col-span-2">
    @if(!empty($component['heading']))<h2 class="mt-0">{{ $component['heading'] }}</h2>@endif
    <ul class="accordion">
        @foreach($data as $item)
            <li>
                <a href="#definition-{{ $item['promo_item_id'] }}" id="definition-{{ $item['promo_item_id'] }}"><span aria-hidden="true"></span>{{ $item['title'] }}</a>
                <div class="content">{!! $item['description'] !!}</div>
            </li>
        @endforeach
    </ul>
</div>
