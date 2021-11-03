{{--
    $social => array // ['title','link']
--}}
<div class="bg-green-800 print:bg-transparent py-6 print:hidden">
    <div class="row flex justify-center items-center print:flex-wrap">
        @foreach($social as $item)
            <a href="{{ $item['link'] }}" target="_blank" aria-labelledby="{{ strtolower(trim($item['title'])) }}" rel="noopener" class="flex justify-center items-center h-10 w-10 print:w-auto lg:h-14 lg:w-14 mx-1 sm:mx-2 md:mx-3 lg:mx-4 text-green-50 print:text-black fill-current bg-green-default print:bg-transparent rounded-full transition transition-property-bg transition-delay-none hover:bg-green-200 hover:text-white">
                @svg($item['title'], 'w-6 h-6 lg:w-8 lg:h-8')
            </a>
        @endforeach
    </div>
</div>
