{{--
    $items => array // [['title', 'link']]
    $heading => string // 'Resources'
    $url => string // '/listing.php'
    $link_text => string // 'More items'
--}}
@if(is_array($items) && count($items) > 0)
    <h2>{{ $heading or 'Resources' }}</h2>

    <dl class="listing">
        @foreach($items as $item)
            <dt>
                <a href="{{ $item['link'] }}">{{ $item['title'] }}</a>
            </dt>
        @endforeach
    </dl>

    @if(isset($url))<a href="{{ $url }}" class="more-link">{{ $link_text or 'View more' }}</a>@endif
@endif
