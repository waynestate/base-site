{{--
    $items => array // ['title', 'description']
--}}
<ul class="accordion">
    @foreach($items as $key=>$item)
        <li>
            <a href="#definition-{{ $key }}" id="definition-{{ $key }}"><span aria-hidden="true"></span>{{ $item['title'] }}</a>
            <div class="content">{!! $item['description'] !!}</div>
        </li>
    @endforeach
</ul>
