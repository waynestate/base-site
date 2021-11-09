{{--
    $social => array // ['title','link']
--}}
<div class="pt-4 print:hidden">
    <div class="row flex items-center print:flex-wrap">
        @foreach($social as $item)
            <a href="{{ $item['link'] }}" target="_blank" aria-labelledby="{{ strtolower(trim($item['title'])) }}" rel="noopener"
                class="flex justify-center items-center mr-4 text-green-100 fill-current hover:text-white">
                @svg($item['title'], 'w-4 h-4')
            </a>
        @endforeach
    </div>
</div>
