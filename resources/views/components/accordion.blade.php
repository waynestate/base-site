{{--
    $items => array // [['title', 'description']]
--}}
@if(is_array($items) && count($items) > 0)
    <ul class="accordion">
        @foreach($items as $key=>$item)
            <li>
                <a href="#definition-{{ $key }}">{{ $item['title'] }}</a>
                <div class="content" id="definition-{{ $key }}">{!! $item['description'] !!}</div>
            </li>
        @endforeach
    </ul>
@endif
