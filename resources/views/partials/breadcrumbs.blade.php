{{--
    $breadcrumbs => array // [['display_name', 'relative_url']]
--}}
<nav role="navigation" class="breadcrumbs">
    <ul class="breadcrumbs">
        @foreach($breadcrumbs as $key=>$crumb)
            @if($key == 0)
                <li class="first">
                    <a href="/" title="{{ strip_tags($crumb['display_name']) }}"><span class="icon-home"></span><span class="text">{{ strip_tags($crumb['display_name']) }}</span></a>
                    <span class="icon-right-open-mini"></span>
            @elseif($key == (count($breadcrumbs) - 1))
                <li class="last">
                    {{ $crumb['display_name'] }}
            @else
                <li>
                <a href="{{ $crumb['relative_url'] }}" title="{{ strip_tags($crumb['display_name']) }}">{{ $crumb['display_name'] }}</a>
                <span class="icon-right-open-mini"></span>
            @endif
            </li>
        @endforeach
    </ul>
</nav>