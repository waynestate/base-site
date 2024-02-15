{{--
    $hero => array // ['relative_url', 'title', 'description']
--}}

<div class="hero__wrapper w-full relative">
    <div class="hero__primary-image h-hero max-h-hero w-full bg-cover bg-center relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $hero['relative_url'] }}')" @else data-src="{{ $hero['relative_url'] }}"@endif></div>
    <div class="hero__content-position relative lg:absolute print:relative p-6 lg:p-0 lg:bottom-0 lg:inset-x-0 lg:bg-gradient-darkest lg:pt-20">
        <div class="row">
            <{{ !empty($hero['link']) ? 'a href='.$hero['link'] : 'div' }} class="hero__content relative block {{ !empty($hero['link']) ? 'group no-underline ' : '' }} p-4 lg:pb-2 pl-6 lg:pl-4 pb-8 border-l-12 border-gold border-solid lg:border-0 text-green-900 lg:text-white lg:white-links">
                <div class="hero__title lg:drop-shadow-px leading-tight mt-4 text-3xl mb-3 lg:text-5xl group-hover:underline">
                    {!! strip_tags($hero['title'], ['em', 'strong']) !!}
                </div>
                @if(!empty($hero['description']))
                    <div class="hero__description text-lg content">
                        @if(!empty($hero['link']))
                            {!! preg_replace(array('"<a href(.*?)>"', '"</a>"'), array('',''), $hero['description']) !!}
                        @else
                            {!! $hero['description'] !!}
                        @endif
                    </div>
                @endif
                @yield('hero-buttons')
            <{{ !empty($hero['link']) ? '/a' : '/div' }}>
        </div>
    </div>
</div>
