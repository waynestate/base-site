{{--
    $items => array // ['title', 'description']
--}}
<ul class="accordion">
    @foreach($items as $key=>$item)
        <li>
            <a class="symbol" href="#definition-{{ $key }}" id="definition-{{ $key }}">{{ $item['title'] }}</a>
            <div class="content">{!! $item['description'] !!}</div>
        </li>
    @endforeach
</ul>
