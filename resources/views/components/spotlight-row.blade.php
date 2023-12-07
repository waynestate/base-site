{{--
    $data => array // ['title', 'excerpt', 'description', 'filename_url', 'filename_alt_text', 'link']
--}}
@foreach($data as $item)
    <{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} class="{{ !empty($item['link']) ? 'group' : '' }}">
        <blockquote class="flex gap-x-6 border-0 m-0 p-0 text-black">
            <div class="flex flex-wrap content-center w-full">
                <div class="content w-full text-lg md:text-xl lg:text-xl lg:leading-relaxed">{!! $item['description'] !!}</div>
                <div class="w-full flex items-center lg:items-start gap-x-2 mb-4 lg:mb-2">
                    <div class="w-20 lg:w-1/4 lg:absolute top-0 right-0 shrink-0">
                        <div class="lg:hidden rounded-full overflow-hidden w-full pt-full border relative">
                            @image($item['filename_url'], $item['filename_alt_text'], 'block inset-0 absolute z-10 w-full h-full object-cover')
                        </div>
                    </div>
                    <cite class="not-italic">
                        <span class="block font-bold mb-0 text-lg xl:text-xl group-hover:underline">{{ $item['title'] }}</span>
                        <span class="block 2xl:text-lg">{{ $item['excerpt'] }}</span>
                    </cite>
                </div>
            </div>
            <div class="hidden lg:block shrink-0 grow-0 w-1/3">
                <div class="rounded-full overflow-hidden w-full pt-full border relative">
                    @image($item['filename_url'], $item['filename_alt_text'], 'block inset-0 absolute z-10 w-full h-full object-cover')
                </div>
            </div>
        </blockquote>
    <{{ !empty($item['link']) ? '/a' : '/div' }}>
    @if(!$loop->last)
        <hr class="mb-6" />
    @endif
@endforeach
