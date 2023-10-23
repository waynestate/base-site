{{--
    $item => array // ['title', 'description']
--}}
<div class="col-span-2 md:col-span-1 content">
    @if(!empty($data[0]['component']['heading']))<h2 class="mt-0">{{ $data[0]['component']['heading'] }}</h2>@endif
    @foreach($data as $content_block)
        @if(!empty($data[0]['component']['heading']))
            <h3>{{ $content_block['title'] }}</h3>
        @else
            <h2 class="mt-0">{{ $content_block['title'] }}</h2>
        @endif
        {!! $content_block['description'] !!}
    @endforeach
</div>
