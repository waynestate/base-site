{{--
    $hero => array // ['relative_url', 'title', 'description']
--}}

<div class="hero__wrapper w-full relative">
    <div class="hero__primary-image aspect-hero max-h-hero w-full bg-cover bg-center relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $hero['relative_url'] }}')" @else data-src="{{ $hero['relative_url'] }}"@endif></div>
    <div class="hero__content-position relative mt:absolute print:relative p-6 mt:p-0 mt:bottom-0 mt:inset-x-0 mt:bg-gradient-darkest mt:pt-20">
        <div class="row">
            <{{ (!empty($hero['link']) && empty($hero_buttons)) ? 'a href='.$hero['link'] : 'div' }} class="hero__content relative block {{ !empty($hero['link']) && empty($hero_buttons) ? 'group no-underline ' : '' }} p-4 mt:pb-2 pl-6 mt:pl-4 mt:pb-8 border-l-12 border-gold border-solid mt:border-0 text-green-900 mt:text-white mt:white-links">
                <div class="hero__title mt:drop-shadow-px leading-tight mt-4 text-4xl mb-4 mt:text-5xl group-hover:underline">
                    {!! strip_tags($hero['title'], ['em', 'strong']) !!}
                </div>
                @if(!empty($hero['description']))
                    <div class="hero__description text-lg content -mt-2">
                        @if(!empty($hero['link']))
                            {!! preg_replace(array('"<a href(.*?)>"', '"</a>"'), array('',''), $hero['description']) !!}
                        @else
                            {!! $hero['description'] !!}
                        @endif
                    </div>
                @endif
                @if(!empty($hero_buttons))
                    <div class="relative mt-6 mb-4 mt:mb-0">
                        @include('components/button-row', ['data' => $hero_buttons['data'], 'component' => $hero_buttons['component']])
                    </div>
                @endif
            {!! (!empty($hero['link']) && empty($hero_buttons)) ? '</a>' : '</div>' !!}
        </div>
    </div>
</div>
