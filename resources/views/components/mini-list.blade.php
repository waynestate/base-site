{{--
    $items => array // [['title', 'link']]
    $heading => string // 'Resources'
    $url => string // '/listing.php'
    $link_text => string // 'More items'
--}}
<h2>{{ $heading ?? 'Resources' }}</h2>

<ul class="listing">
    @foreach($items as $item)
        <li>
            <a href="{{ $item['link'] }}">{{ $item['title'] }}</a>
        </li>
    @endforeach
</ul>

@if(isset($url))<a href="{{ $url }}" class="more-link">{{ $link_text ?? 'View more' }}</a>@endif
