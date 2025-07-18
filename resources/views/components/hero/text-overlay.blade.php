{{--
    $item => array // ['relative_url', 'title', 'description']
--}}

<div class="hero__wrapper hero--text-overlay">
    <div class="hero__primary-image {{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $item['relative_url'] }}')" @else data-src="{{ $item['relative_url'] }}"@endif></div>
    <div class="hero__content-position">
        <div class="hero__content">
            <div class="hero__title">
                @if(!empty($item['link']))<a href="{{ $item['link'] }}">@endif
                    {!! strip_tags($item['title'], ['em']) !!}
                @if(!empty($item['link']))</a>@endif
            </div>
            @if(!empty($item['description']))
                <div class="hero__description">
                    {!! $item['description'] !!}
                </div>
            @endif
        </div>
        @if(!empty($base['hero_buttons']))
            <div class="hero__buttons">
                @include('components/button-row', ['data' => $base['hero_buttons']['data'], 'component' => $base['hero_buttons']['component']])
            </div>
        @endif
    </div>
</div>
