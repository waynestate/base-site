{{--
    $breadcrumbs => array // [['display_name', 'relative_url']]
--}}
<nav class="breadcrumbs" aria-label="Breadcrumbs">
    <ul class="breadcrumbs">
        @foreach($breadcrumbs as $key=>$crumb)
            @if($key == 0)
                <li class="first">
                    <a href="/"><span class="icon-home"></span><span class="visuallyhidden">{{ strip_tags($crumb['display_name']) }}</span></a>
                    <span class="icon-right-open-mini"></span>
            @elseif($key == (count($breadcrumbs) - 1))
                <li class="last">
                    {{ $crumb['display_name'] }}
            @else
                <li>
                <a href="{{ $crumb['relative_url'] }}">{{ $crumb['display_name'] }}</a>
                <span class="icon-right-open-mini"></span>
            @endif
            </li>
        @endforeach
    </ul>
</nav>
