{{--
    $items => array // [['title', 'link']]
    $heading => string // 'Resources'
    $url => string // '/listing.php'
    $link_text => string // 'More items'
--}}
<h2{!! !empty($class) ? ' class="'.$class.'"' : '' !!}>{{ $heading ?? 'Resources' }}</h2>

<ul class="list-reset">
    @foreach($items as $item)
        <li class="mb-4">
            <a href="{{ $item['link'] }}" class="underline hover:no-underline font-normal">{{ $item['title'] }}</a>
        </li>
    @endforeach
</ul>

@if(!empty($url))<a href="{{ $url }}" class="block my-4 underline hover:no-underline">{{ $link_text ?? 'View more' }}</a>@endif
