{{--
    $hero => array // ['relative_url', 'title', 'description', 'link']
--}}

<div class="hero__wrapper w-full relative xl:flex items-center">
    <div class="hero__primary-image w-full xl:w-[60%] shrink-0">
        <div class="w-full aspect-video bg-center bg-cover{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $hero['relative_url'] }}')" @else data-src="{{ $hero['relative_url'] }}"@endif>
             <span class="visually-hidden">{{ $hero['filename_alt_text'] }}
        </div>
    </div>

    <div class="hero__content-position relative p-6 xl:px-12 2xl:px-16">
        <div class="hero__content border-l-12 border-gold border-solid pl-6 2xl:pl-8 pt-4 pb-8">
            <h2 class="hero__title text-green-700 3xl:text-4xl mb-3 font-black">
                @if(!empty($hero['link']))<a href="{{ $hero['link'] }}" class="hero__link text-green-700 no-underline hover:underline focus:underline">@endif
                    {!! strip_tags($hero['title'], ['em', 'strong']) !!}
                @if(!empty($hero['link']))</a>@endif
            </h2>
            <div class="hero__description text-lg 3xl:text-xl text-green-700 content">
                @if(!empty($hero['description']))
                    @if(!empty($hero['link']))
                        {!! preg_replace(array('"<a href(.*?)>"', '"</a>"'), array('',''), $hero['description']) !!}
                    @else
                        {!! $hero['description'] !!}
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
