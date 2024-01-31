{{--
    $articles => array // ['link', 'title']
    $url => string '/news/'
    $link_text => string // 'More news'
--}}
@if(!empty($data['data']))
    <ul>
        @foreach($data['data'] as $item)
            @if($loop->iteration === 1)
                <li class="bg-green-800">
                    <a href="{{ $item['link'] }}" class="relative block mb-6 group">
                        <img class="lazy w-full" data-src="{{ $item['featured']['url'] ?? 'https://wayne.edu/opengraph/wsu-social-share.png' }}" alt="{{ $item['featured']['alt_text'] ?? "Wayne State University" }}">
                        <div class="bg-gradient-darkest absolute inset-x-0 bottom-0">
                            <div class="w-full text-white font-bold relative text-xl p-4 pt-8 group-hover:underline">{{ $item['title'] }}</div>
                        </div>
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ $item['link'] }}" class="flex mb-6 group">
                        <div class="shrink-0 w-1/2 pr-4">
                            <img class="lazy" data-src="{{ $item['featured']['url'] ?? 'https://wayne.edu/opengraph/wsu-social-share.png' }}" alt="{{ $item['featured']['alt_text'] ?? "Wayne State University" }}">
                        </div>
                        <div class="font-bold group-hover:underline">{{ $item['title'] }}</div>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
    
    <div class="mt-6">
        <a href="/{{ !empty($base['site']['subsite-folder']) ?? '' }}{{ $component['news_route'] ?? config('base.news_listing_route') }}" class="button">{{ $component['link_text'] ?? 'More news' }}</a>
    </div>
@endif
