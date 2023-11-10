{{--
    $images => array // ['relative_url', 'title', 'description']
--}}

<div{!! (in_array($base['page']['controller'], config('base.hero_full_controllers'))) ? ' role="complementary"' : '' !!} class="mb-4 mt:mx-0{{ !empty($images) && count($images) > 1 ? ' rotate' : '' }}{{!in_array($base['page']['controller'], config('base.hero_full_controllers'))  ? '  -mx-4' : ' ' }}">
    @foreach($images as $image)
        @if(!empty($image['option']) && $image['option'] === "SVG Overlay" && in_array($base['page']['controller'], config('base.hero_full_controllers')))
            <div class="w-full relative overflow-hidden">
                @if(!empty($image['link']))<a href="{{  $image['link'] }}">@endif
                    <div class="pt-hero w-full bg-cover bg-top {{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
                    <div class="absolute print:relative inset-0 flex items-center justify-center">
                        <img src="{{ $image['secondary_relative_url'] }}" alt="{{ $image['secondary_alt_text'] }}" class="w-full max-w-full max-h-full">
                    </div>
                @if(!empty($image['link']))</a>@endif
            </div>
        @elseif(!empty($image['option']) && $image['option'] === "Logo Overlay" && in_array($base['page']['controller'], config('base.hero_full_controllers')))
            <div class="mb-4 full min-h-hero relative overflow-hidden flex bg-green-900">
                <div class="inset-0 absolute print:relative bg-cover bg-top opacity-20 {{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
                <div class="w-full relative text-white flex flex-col justify-center">
                    <div class="row w-full px-4 pt-10 pb-6 text-center md:white-links content">
                        @if(!empty($image['secondary_relative_url']))<img class="mx-auto mb-4" src="{{ $image['secondary_relative_url'] }}" alt="{{ $image['secondary_alt_text'] }}">@endif
                        <div class="md:text-shadow-darkest leading-tight text-2xl mb-1 @if(in_array($base['page']['controller'], config('base.hero_full_controllers')))xl:text-5xl @else xl:text-3xl @endif">{{ $image['title'] }}</div>
                        @if(!empty($image['description']))<div class="md:text-lg">{!! $image['description'] !!}</div>@endif
                    </div>
                </div>
            </div>
        @elseif(!empty($image['option']) && $image['option'] === "Text Overlay")
            <div class="w-full relative">
                <div class="pt-hero w-full bg-cover bg-top relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
                <div class="relative md:absolute print:relative md:bottom-0 md:inset-x-0 md:text-white md:white-links content md:bg-gradient-darkest">
                    <div class="row">
                        <div class="mx-4 relative pb-0 pt-4 @if(in_array($base['page']['controller'], config('base.hero_full_controllers'))) md:pb-2 md:pt-8 md:pt-20 @else md:pt-12 @endif">
                            <div class="md:text-shadow-darkest leading-tight text-2xl mb-1 @if(in_array($base['page']['controller'], config('base.hero_full_controllers')))xl:text-5xl @else xl:text-3xl @endif">{{ $image['title'] }}</div>
                            @if(!empty($image['description']))<div class="md:text-lg">{!! $image['description'] !!}</div>@endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="w-full">
                <div class="pt-hero w-full bg-cover bg-top relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
            </div>
        @endif
    @endforeach
</div>
