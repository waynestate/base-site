{{--
    $item => array // ['relative_url', 'title', 'description', 'link']
--}}

<div class="hero__wrapper hero--half">
    <div class="hero__primary-image-wrapper">
        <img src="{{ $item['relative_url']}}" alt="{{ $item['filename_alt_text'] }}" class="hero__primary-image" />
    </div>

    <div class="hero__content-position">
        <div class="hero__content">
            <h2 class="hero__title">
                @if(!empty($item['link']))<a href="{{ $item['link'] }}" class="hero__link">@endif
                    {!! strip_tags($item['title'], ['em', 'strong']) !!}
                @if(!empty($item['link']))</a>@endif
            </h2>
            <div class="hero__description">
                @if(!empty($item['description']))
                    @if(!empty($item['link']))
                        {!! preg_replace(['"<a href(.*?)>"', '"</a>"'], '', $item['description']) !!}
                    @else
                        {!! $item['description'] !!}
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
