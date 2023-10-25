{{--
    $item => single // ['title', 'excerpt', 'description', 'link', 'filename_url', 'filename_alt_text']
--}}

<div class="col-span-2">
    @if(!empty($component['heading']))<h2 class="mt-0">{{ $component['heading'] }}</h2>@endif

    @if(!empty($component['columns']) && $component['columns'] == 1)
        <div class="grid gap-4">
            @foreach($data as $item)
                <{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} class="flex items-start space-x-3 md:space-x-6 mb-8 {{ !empty($item['link']) ? 'group' : '' }}">
                    @if(!empty($item['filename_url']))
                        @image($item['filename_url'], $item['filename_alt_text'], 'w-1/4 shrink-0')
                    @endif

                    <div class="md:mt-0 content">
                        <div class="font-bold text-xl group-hover:underline group-focus:underline">{{ $item['title'] }}</div>
                        @if(!empty($item['excerpt']))
                            <div class="text-black mt-1">
                                {!! strip_tags($item['excerpt'], ['em', 'strong']) !!}
                            </div>
                        @endif
                        @if(!empty($item['description']))
                            @if (!empty($item['link']))
                                <div class="text-black mt-1">{!! preg_replace(array('"<a href(.*?)>"', '"</a>"'), array('',''), $item['description']) !!}</div>
                            @else
                                <div class="text-black mt-1">{!! $item['description'] !!}</div>
                            @endif
                        @endif
                    </div>
                <{{ !empty($item['link']) ? '/a' : '/div' }}>
            @endforeach
        </div>
    @else
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-{{ !empty($component['columns']) && $component['columns'] >= 3 ? '3' : '2' }} xl:grid-cols-{{ !empty($component['columns']) ? $component['columns'] : '3' }}">
            @foreach($data as $item)
                <{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} class="flex items-start space-x-3 md:space-x-0 md:block {{ !empty($item['link']) ? 'group' : '' }}">
                    @if(!empty($item['filename_url']))
                        @image($item['filename_url'], $item['filename_alt_text'], 'w-1/4 shrink-0 md:shrink md:w-full')
                    @endif

                    <div class=>
                        <div class="w-full relative md:pt-2">
                            <div class="font-bold text-xl group-hover:underline group-focus:underline">{{ $item['title'] }}</div>
                            @if(!empty($item['excerpt']))
                                <div class="block mt-1 font-normal text-black">{!! strip_tags($item['excerpt'], ['em','strong']) !!}</div>
                            @endif
                            @if(!empty($item['description']))
                                @if (!empty($item['link']))
                                    <div class="text-black mt-1">{!! preg_replace(array('"<a href(.*?)>"', '"</a>"'), array('',''), $item['description']) !!}</div>
                                @else
                                    <div class="text-black mt-1">{!! $item['description'] !!}</div>
                                @endif
                            @endif
                        </div>
                    </div>
                <{{ !empty($item['link']) ? '/a' : '/div' }}>
            @endforeach
        </div>
    @endif
</div>
