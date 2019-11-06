{{--
    $images => array // ['relative_url', 'title', 'description']
--}}

<div{!! (in_array($page['controller'], config('base.hero_full_controllers'))) ? ' role="complementary"' : '' !!} class="mb-4 mt:mx-0{{ !empty($images) && count($images) > 1 ? ' rotate' : '' }}{{!in_array($page['controller'], config('base.hero_full_controllers'))  ? '  -mx-4' : ' ' }}">
    @foreach($images as $image)
        @if(!empty($image['option']) && $image['option'] === "SVG Overlay")
            <div class="w-full relative overflow-hidden">
                @if(!empty($image['link']))<a href="{{  $image['link'] }}">@endif
                    <div class="pt-hero w-full bg-cover bg-top {{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <img src="{{ $image['secondary_relative_url'] }}" alt="{{ $image['secondary_alt_text'] }}" class="w-full max-w-full max-h-full">
                    </div>
                @if(!empty($image['link']))</a>@endif
            </div>
        @elseif(!empty($image['option']) && $image['option'] === "Logo Overlay")
            <div class="mb-4 full min-h-hero relative overflow-hidden flex bg-green-darker">
                <div class="inset-0 absolute bg-cover bg-top opacity-25 {{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
                <div class="w-full relative text-white flex flex-col justify-center">
                    <div class="row w-full px-4 pt-10 pb-6 text-center">
                        @if(!empty($image['secondary_relative_url']))<img class="mx-auto mb-4" src="{{ $image['secondary_relative_url'] }}" alt="{{ $image['secondary_alt_text'] }}">@endif
                        <h1 class="leading-tight text-2xl mb-1 @if(in_array($page['controller'], config('base.hero_full_controllers')))xl:text-5xl @else xl:text-3xl @endif">{{ $image['title'] }}</h1>
                        @if(!empty($image['description']))<div class="md:text-lg md:white-links content">{!! $image['description'] !!}</div>@endif
                    </div>
                </div>
            </div>
        @elseif(!empty($image['option']) && $image['option'] === "Text Overlay")
            <div class="w-full relative">
                <div class="pt-hero w-full bg-cover bg-top relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
                <div class="relative md:absolute md:bottom-0 md:inset-x-0 md:text-white md:text-shadow-dark md:bg-gradient-darkest">
                    <div class="row">
                        <div class="mx-4 relative pb-0 pt-4 md:pb-4 md:pt-10 xl:pb-10 xl:pt-20">
                            <h1 class="leading-tight text-2xl mb-1 @if(in_array($page['controller'], config('base.hero_full_controllers')))xl:text-5xl @else xl:text-3xl @endif">{{ $image['title'] }}</h1>
                            @if(!empty($image['description']))<p class="pr-2 md:text-lg md:white-links content">{!! strip_tags($image['description'], '<a>') !!}</p>@endif
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

