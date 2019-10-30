{{--
    $images => array // ['relative_url', 'title', 'description']
--}}

<div{!! (in_array($page['controller'], config('base.hero_full_controllers'))) ? ' role="complementary"' : '' !!} class="hero mb-4 mt:mx-0{{ !empty($images) && count($images) > 1 ? ' rotate' : '' }}{{!in_array($page['controller'], config('base.hero_full_controllers'))  ? '  -mx-4' : ' ' }} bg-grey-lighter md:bg-transparent">
    @if(in_array($page['controller'], config('base.hero_text_controllers')))
        @foreach($images as $image)
            @if(!empty($image['option']))
                @if($image['option'] === "SVG Overlay")
                    <div class="w-full relative overflow-hidden">
                        @if(!empty($image['link']))<a href="{{  $image['link'] }}">@endif
                            <div class="pt-hero w-full bg-cover bg-gradient-darkest bg-top {{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <img src="{{ $image['secondary_relative_url'] }}" alt="{{ $image['secondary_alt_text'] }}" class="w-full max-w-full max-h-full">
                            </div>
                        @if(!empty($image['link']))</a>@endif
                    </div>
                @elseif($image['option'] === "Description Overlay")
                    <div class="mb-4 full min-h-hero relative overflow-hidden flex bg-green-darkest">
                        <div class="inset-0 absolute bg-cover bg-top opacity-25 {{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
                        <div class="w-full relative text-white flex flex-col justify-center">
                            <div class="row w-full px-4 py-10 text-center">
                                @if(!empty($image['secondary_relative_url']))<img class="mx-auto mb-4" src="{{ $image['secondary_relative_url'] }}" alt="{{ $image['secondary_alt_text'] }}">@endif
                                <h1 class="leading-tight text-2xl mb-1 @if(in_array($page['controller'], config('base.hero_full_controllers')))xl:text-5xl @else xl:text-3xl @endif">{{ $image['title'] }}</h1>
                                @if(!empty($image['description']))<div class="md:text-lg md:white-links content">{!! $image['description'] !!}</div>@endif
                            </div>
                        </div>
                    </div>

                @endif
            @else
                <div class="w-full relative">
                    <div class="pt-hero w-full bg-cover md:bg-gradient-darkest md:overflow-hidden bg-top relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
                    <div class="md:absolute md:bottom-0 md:inset-x-0 md:text-white md:text-shadow-dark @if(count($images) > 1) p-6 @else py-4 @if(in_array($page['controller'], config('base.hero_full_controllers')))lg:pb-10 @endif @endif">
                        <div class="row">
                            <div class="mx-4">
                                <h1 class="leading-tight text-2xl mb-1 @if(in_array($page['controller'], config('base.hero_full_controllers')))xl:text-5xl @else xl:text-3xl @endif">{{ $image['title'] }}</h1>
                                @if(!empty($image['description']))<p class="pr-2 md:text-lg md:white-links content">{!! strip_tags($image['description'], '<a>') !!}</p>@endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        @foreach($images as $image)
            <div class="w-full">
                <div class="pt-hero w-full bg-cover bg-top relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
            </div>
        @endforeach
    @endif
</div>

