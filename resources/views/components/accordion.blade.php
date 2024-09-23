{{--
    $items => array // ['title', 'description']
--}}
<ul class="accordion">
    @foreach($data as $item)
        <li>
            <a href="#definition-{{ $item['promo_item_id'] }}" id="definition-{{ $item['promo_item_id'] }}"><span aria-hidden="true"></span>{{ $item['title'] }}</a>
            <div class="content">
                <div class="flex gap-6 items-center flex-col {{ !empty($item['option']) && ($item['option'] === 'Left' || $item['option'] === 'Center') ? (($item['option'] === 'Center') ? '' : 'mt:flex-row-reverse mt:items-start') : 'mt:items-start mt:flex-row'}}">
                    <div class="w-full">{!! $item['description'] !!}</div>

                    @if(!empty($item['relative_url']))
                        <figure class="m-0 w-2/3 shrink-0 {{ !empty($item['option']) && $item['option'] === 'Center' ? '' : 'mt:w-2/5' }}">
                            <img src="{{ $item['relative_url'] }}" alt="{{ $item['filename_alt_text'] }}"> 
                            @if(!empty($item['excerpt']))<figcaption>{{ $item['excerpt'] }}</figcaption>@endif
                        </figure>
                    @endif
                </div>
            </div>
        </li>
    @endforeach
</ul>
