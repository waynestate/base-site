{{--
    $articles => array // ['link', 'title']
    $url => string '/news/'
    $link_text => string // 'More news'
--}}
<div class="col-span-2 md:col-span-1">
    @if(!empty($data[0]['component']['heading']))<h2 class="mt-0">{{ $data[0]['component']['heading'] }}</h2>@endif

    @if(!empty($data))
        <ul>
            @foreach($data as $item)
                <li class="mb-4">
                    <a href="{{ $item['link'] }}" class="underline hover:no-underline font-normal">
                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    <a href="/{{ config('base.news_listing_route').'/' }}" class="block my-4 underline hover:no-underline">More news</a>
</div>
