{{--
    $social => array // [['title','link']]
--}}
<div class="bg-blue-darkest pt-6 pb-4 mt-8">
    <ul class="row list-reset text-center">
        @foreach($social as $item)
            <li class="inline{{ $loop->last !== true ? ' mr-8' : '' }}">
                <a href="{{ $item['link'] }}" target="_blank" rel="noopener" class="inline-block text-grey hover:text-white">
                    <span class="icon-{{ strtolower($item['title']) }} table-cell align-middle text-3xl h-14 w-14 bg-grey-darkest rounded-full transition transition-property-bg transition-delay-none hover:bg-green-lightest"></span><p class="visually-hidden">{{ $item['title'] }}</p>
                </a>
            </li>
        @endforeach
    </ul>
</div>
