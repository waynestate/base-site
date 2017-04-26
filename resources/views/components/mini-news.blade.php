{{--
    $news => array // [['news_id', 'slug', 'title']]
    $site => array // ['subsite-folder']
    $heading => string // 'News'
    $url => string '/news.php'
    $link_text => string // 'More news'
--}}
@if(is_array($news) && count($news) > 0)
    <h2>{{ $heading or 'News' }}</h2>

    <dl class="listing">
        @foreach($news as $item)
            <dt>
                <a href="/{{ ($site['subsite-folder'] !== null) ? $site['subsite-folder'] : '' }}news/{{ $item['slug'] }}-{{ $item['news_id'] }}">
                    {{ $item['title'] }}
                </a>
            </dt>
        @endforeach
    </dl>

    <a href="/{{ $url or 'news/' }}" class="more-link">{{ $link_text or 'More news' }}</a>
@endif
