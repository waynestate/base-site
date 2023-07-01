{{--
    $data => single // ['title', 'excerpt', 'description', 'relative_url']
--}}

<div class="col-span-2 mx-4 my-6">
    <blockquote class="relative flex border-gold border-l-12 pt-4 lg:pl-8 mx-auto my-0">
        <div class="flex flex-wrap items-center w-full">
            <div class="content w-full text-lg md:text-xl lg:text-xl lg:leading-relaxed">{!! $data['description'] !!}</div>
            <div class="w-full flex items-start gap-x-2 mb-4 lg:mb-2">
                <div class="gold-half-circle-bg w-24 lg:w-1/4 lg:absolute top-0 right-0">
                    @image($data['relative_url'], $data['filename_alt_text'], 'block rounded-full relative z-10')
                </div>
                <div>
                    <h2 class="mb-0 text-lg xl:text-xl">{{ $data['title'] }}</h2>
                    <cite class="not-italic xl:text-lg">{{ $data['excerpt'] }}</cite>
                </div>
            </div>
        </div>
        <div class="hidden lg:block shrink-0 grow-0 w-1/3 pt-[25%]">
            {{-- Absolutely positioned image placeholder --}}
        </div>
    </blockquote>
</div>
