{{--
    $images => array // ['relative_url']
--}}

<div class="hero{{ !empty($images) && count($images) > 1 ? ' rotate' : '' }}{{ !empty($show_site_menu) && $show_site_menu === true ? ' contained' : ' full' }}">
    @foreach($images as $image)
        @if($loop->first === true)
            <div class="carousel-cell" style="background-image: url('{{ $image['relative_url'] }}')">
        @else
            <div class="carousel-cell lazy" data-src="{{ $image['relative_url'] }}">
        @endif

            @if(!empty($image['excerpt']) && config('app.hero_text_enabled') && in_array($page['controller'], config('app.hero_text_controllers')))
                <div class="bg-green-darker text-white p-4 absolute pin-b pin-l pin-r">
                    {{ $image['excerpt'] }} @if(!empty($image['link'])) <a href="{{ $image['link'] }}" class="text-white underline font-bold pl-2 hover:no-underline">{{ config('app.hero_text_more') }}</a>@endif
                </div>
            @endif
        </div>
    @endforeach
</div>
