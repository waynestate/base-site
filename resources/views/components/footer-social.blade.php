{{--
    $social => array // ['title','link']
--}}
<div class="bg-green-800 py-6 print:hidden">
    <div class="row flex justify-center items-center">
        @foreach($social as $item)
            <a href="{{ $item['link'] }}" target="_blank" aria-labelledby="{{ strtolower(trim($item['title'])) }}" rel="noopener" 
                class="flex justify-center items-center h-10 w-10 mx-1 sm:mx-2 md:mx-3 text-green-100 fill-current bg-green-600 rounded-full transition transition-property-bg transition-delay-none focus:bg-gold-500 hover:bg-gold-500 hover:text-white focus:text-white">
                @svg($item['title'], 'w-6 h-6')
            </a>
        @endforeach
    </div>
</div>
