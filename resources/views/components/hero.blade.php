{{--
    $images => array // ['relative_url']
--}}

<aside class="mb-4 mt:mx-0{{ !empty($images) && count($images) > 1 ? ' rotate' : '' }}{{!in_array($page['controller'], config('base.hero_full_controllers'))  ? '  -mx-4' : ' ' }} bg-grey-lighter md:bg-transparent">
    @if(in_array($page['controller'], config('base.hero_text_controllers')))
        @foreach($images as $image)
            <div class="w-full relative" aria-labelledby="hero-image-{{ $loop->iteration }}">
                <div class="pt-hero w-full bg-cover bg-green-darkest md:bg-gradient-dark md:overflow-hidden bg-top relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
                <div class="md:absolute md:pin-b md:pin-x md:text-white md:text-shadow-dark @if(count($images) > 1) p-6 @else py-4 @if(in_array($page['controller'], config('base.hero_full_controllers')))lg:pb-10 @endif @endif">
                    <div class="row">
                        <div class="mx-4">
                            <h1 id="hero-image-{{ $loop->iteration }}" class="leading-tight text-2xl @if(in_array($page['controller'], config('base.hero_full_controllers')))xl:text-5xl @else xl:text-3xl @endif">{{ $image['title'] }}</h1>
                            @if(!empty($image['excerpt']))<p class="inline pr-2 md:text-lg">{{ $image['excerpt'] }}</p>@endif
                            @if(!empty($image['link']))<a href="{{ $image['link'] }}" class="underline font-bold hover:no-underline md:text-white md:text-lg">{{ config('base.hero_text_more') }}</a>@endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        @foreach($images as $image)
            <div class="w-full">
                <div class="pt-hero w-full bg-cover bg-top relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
            </div>
        @endforeach
    @endif
</aside>
