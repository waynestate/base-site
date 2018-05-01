{{--
    $breadcrumbs => array // [['display_name', 'relative_url']]
--}}
<nav class="breadcrumbs mt-6" aria-label="Breadcrumbs">
    <ul class="list-reset text-sm">
        @foreach($breadcrumbs as $key=>$crumb)
            @if($key == 0)
                <li class="first inline">
                    <a href="/"><span class="icon-home text-black text-lg"></span><span class="visually-hidden">{{ strip_tags($crumb['display_name']) }}</span></a>
                    <span class="icon-right-open-mini"></span>
            @elseif($key == (count($breadcrumbs) - 1))
                <li class="font-bold text-green-dark inline">
                    {{ $crumb['display_name'] }}
            @else
                <li class="inline">
                <a href="{{ $crumb['relative_url'] }}" class="text-green-dark hover:underline">{{ $crumb['display_name'] }}</a>
                <span class="icon-right-open-mini"></span>
            @endif
            </li>
        @endforeach
    </ul>
</nav>
