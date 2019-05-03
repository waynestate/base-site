{{--
    $items => array // ['title', 'description']
--}}
<ul class="accordion">
    @foreach($items as $key=>$item)
        <li>
            <a href="#definition-{{ $key }}"><span aria-hidden="true"></span>{{ $item['title'] }}</a>
            <div class="content" id="definition-{{ $key }}">{!! $item['description'] !!}</div>
        </li>
    @endforeach
</ul>
