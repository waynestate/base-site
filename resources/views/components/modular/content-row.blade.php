<div class="col-span-2 content">
    @if(!empty($data[0]['group']['heading']))<h2>{{ $data[0]['group']['heading'] }}</h2>@endif
    @foreach($data as $content_block)
        @if(!empty($data[0]['group']['heading']))
            <h3>{{ $content_block['title'] }}</h3>
        @else
            <h2>{{ $content_block['title'] }}</h2>
        @endif
        {!! $content_block['description'] !!}
    @endforeach
</div>
