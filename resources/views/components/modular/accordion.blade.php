{{--
    $items => array // ['title', 'description']
--}}
<div class="col-span-2">
    @if(!empty($data[0]['group']['heading']))<h2 class="mt-0">{{ $data[0]['group']['heading'] }}</h2>@endif
    <ul class="accordion">
        @foreach($data as $key=>$item)
            <li>
                <a href="#definition-{{ $key }}" id="definition-{{ $key }}"><span aria-hidden="true"></span>{{ $item['title'] }}</a>
                <div class="content">{!! $item['description'] !!}</div>
            </li>
        @endforeach
    </ul>
</div>
