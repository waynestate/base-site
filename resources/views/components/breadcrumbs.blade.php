{{--
    $breadcrumbs => array // ['display_name', 'relative_url']
--}}
<nav class="mt-6 mb-2" aria-label="Breadcrumbs">
    <ul class="text-sm">
        @foreach($breadcrumbs as $key=>$crumb)
            @if($key == 0)
                <li class="inline">
                    <a href="/"><span class="text-black align-middle">@svg('home', 'w-4 h-4')</span></a>
                    <span class="icon-right-open px-2"></span>
            @elseif($key == (count($breadcrumbs) - 1))
                <li class="font-bold text-green inline">
                    {{ $crumb['display_name'] }}
            @else
                <li class="inline">
                <a href="{{ $crumb['relative_url'] }}" class="text-green hover:underline">{{ $crumb['display_name'] }}</a>
                <span class="icon-right-open px-2"></span>
            @endif
            </li>
        @endforeach
    </ul>
</nav>
