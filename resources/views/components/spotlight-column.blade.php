{{--
    $data => array // ['title', 'excerpt', 'description', 'filename_url', 'filename_alt_text', 'link']
--}}
@foreach($data as $item)
    <{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} class="{{ !empty($item['link']) ? 'group' : '' }}">
        <blockquote class="relative flex border-0 m-0 p-0 text-black">
            <div class="flex flex-wrap content-center w-full">
                <div class="content w-full text-lg">{!! $item['description'] !!}</div>
                <div class="w-full flex items-center lg:items-start gap-x-2 mb-4 lg:mb-2">
                    <div class="w-24 lg:w-1/4 shrink-0">
                        <div class="overflow-hidden w-full pt-full border relative">
                            @image($item['filename_url'], $item['filename_alt_text'], 'block inset-0 absolute z-10 w-full h-full object-cover')
                        </div>
                    </div>
                    <cite class="not-italic">
                        <span class="block font-bold mb-0 text-lg group-hover:underline">{{ $item['title'] }}</span>
                        <span class="block">{{ $item['excerpt'] }}</span>
                    </cite>
                </div>
            </div>
        </blockquote>
    <{{ !empty($item['link']) ? '/a' : '/div' }}>
    @if(!$loop->last)
        <hr class="mb-6" />
    @endif
@endforeach
