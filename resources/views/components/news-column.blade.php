{{--
    $articles => array // ['link', 'title']
    $url => string '/news/'
    $link_text => string // 'More news'
--}}
@if(!empty($data['data']))
    <ul>
        @foreach($data['data'] as $item)
            <li class="mb-4">
                <a href="{{ $item['link'] }}" class="underline hover:no-underline font-normal">
                    {{ $item['title'] }}
                </a>
            </li>
        @endforeach
    </ul>

    <div class="mt-6">
        <a href="/{{ $base['site']['subsite-folder'] ?? '' }}{{ $component['news_route'] ?? config('base.news_listing_route') }}" class="button">{{ $component['link_text'] ?? 'More news' }}</a>
    </div>
@endif
