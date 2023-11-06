{{--
    $news => array // [['news_id', 'slug', 'title', filename]]
    $site => array // ['subsite-folder']
    $heading => string // 'News'
    $url => string '/news.php'
    $link_text => string // 'More news'
--}}
<div class="col-span-2">
    @if(!empty($component['heading']))<h2 class="mt-0">{{ $component['heading'] }}</h2>@endif

    @if(!empty($data['data']))
        <ul class="grid gap-x-6 gap-y-4 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-{{ !empty($component['limit']) ? $component['limit'] : '4' }}">
            @foreach($data['data'] as $item)
                <li class="group flex items-start md:block">
                    <a class="group-hover:no-underline flex items-start md:block" href="{{ $item['link'] }}">
                        @image($item['featured']['url'] ?? 'https://wayne.edu/opengraph/wsu-social-share.png', $item['featured']['alt_text'] ?? 'Wayne State University', 'block lazy w-1/3 shrink-0 mr-2 mb-2 md:w-full md:mr-0 md:shrink')
                        <p class="group-hover:underline leading-snug font-bold">{{ $item['title'] }}</p>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="text-center lg:text-right mt-4">
            <a href="/{{ !empty($base['site']['subsite-folder']) ?? '' }}{{ $component['news_route'] ?? config('base.news_listing_route') }}" class="block my-4 underline hover:no-underline">{{ $component['link_text'] ?? 'More news' }}</a>
        </div>
    @endif
</div>
