{{--
    $items => array // ['title', 'link']
    $heading => string // 'Resources'
    $url => string // '/listing'
    $link_text => string // 'View more'
--}}
<h2{!! !empty($class) ? ' class="'.$class.'"' : '' !!}>{{ $heading ?? 'Resources' }}</h2>

<ul>
    @foreach($items as $item)
        <li class="mb-4">
            <a href="{{ $item['link'] }}" class="underline hover:no-underline font-normal">{{ $item['title'] }}</a>
        </li>
    @endforeach
</ul>

@if(!empty($url))<a href="{{ $url }}" class="block my-4 underline hover:no-underline">{{ $link_text ?? 'View more' }}</a>@endif
