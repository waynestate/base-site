{{--
    $images => array // ['relative_url', 'title', 'description']
--}}

{{-- 
<ul
@endif --}}

<{{ (!empty($images) && count($images) > 1) ? 'ul' : 'div' }}{!! (in_array($page['controller'], config('base.hero_full_controllers'))) ? ' role="complementary"' : '' !!} class="mb-4 mt:mx-0{{ !empty($images) && count($images) > 1 ? ' rotate' : '' }}{{!in_array($page['controller'], config('base.hero_full_controllers'))  ? '  -mx-4' : ' ' }} bg-grey-lighter md:bg-transparent{{ (!empty($images) && count($images) > 1) ? ' list-reset' : '' }}">
    @if(in_array($page['controller'], config('base.hero_text_controllers')))
        @foreach($images as $image)
            <{{ (!empty($images) && count($images) > 1) ? 'li' : 'div' }} class="w-full relative" aria-labelledby="hero-image-{{ $loop->iteration }}">
                <div class="pt-hero w-full bg-cover md:bg-gradient-darkest md:overflow-hidden bg-top relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
                <div class="md:absolute md:pin-b md:pin-x md:text-white md:text-shadow-dark @if(count($images) > 1) p-6 @else py-4 @if(in_array($page['controller'], config('base.hero_full_controllers')))lg:pb-10 @endif @endif">
                    <div class="row">
                        <div class="mx-4">
                            <h1 id="hero-image-{{ $loop->iteration }}" class="leading-tight text-2xl mb-1 @if(in_array($page['controller'], config('base.hero_full_controllers')))xl:text-5xl @else xl:text-3xl @endif">{{ $image['title'] }}</h1>
                            @if(!empty($image['description']))<p class="pr-2 md:text-lg md:white-links content">{!! strip_tags($image['description'], '<a>') !!}</p>@endif
                        </div>
                    </div>
                </div>
            </{{ (!empty($images) && count($images) > 1) ? 'li' : 'div' }}>
        @endforeach
    @else
        @foreach($images as $image)
            <{{ (!empty($images) && count($images) > 1) ? 'ul' : 'div' }} class="w-full{{ (!empty($images) && count($images) > 1) ? ' list-reset' : '' }}">
                <div class="pt-hero w-full bg-cover bg-top relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
            </{{ (!empty($images) && count($images) > 1) ? 'ul' : 'div' }}>
        @endforeach
    @endif
</{{ (!empty($images) && count($images) > 1) ? 'ul' : 'div' }}>
