{{--
    $item => array // ['title', 'description']
--}}
@foreach($data as $content_block)
    @if(!empty($component['heading']))
        <h3>{{ $content_block['title'] }}</h3>
    @else
        <h2 class="mt-0">{{ $content_block['title'] }}</h2>
    @endif
    <div class="content">{!! $content_block['description'] !!}</div>
@endforeach
