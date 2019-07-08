{{--
    $social => array // ['title','link']
--}}
<div class="bg-green-darker py-6">
    <div class="row flex justify-center items-center">
            @foreach($social as $item)
                <a href="{{ $item['link'] }}" target="_blank" aria-labelledby="{{ strtolower(trim($item['title'])) }}" rel="noopener" class="flex justify-center items-center h-10 w-10 lg:h-14 lg:w-14 mx-1 sm:mx-2 md:mx-3 lg:mx-4 text-green-lightest fill-current bg-green rounded-full transition transition-property-bg transition-delay-none hover:bg-green-lighter hover:text-white">
                    @svg($item['title'], 'w-6 h-6 lg:w-8 lg:h-8')
                </a>
            @endforeach
        </div>
</div>
