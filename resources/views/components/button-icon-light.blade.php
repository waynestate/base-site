{{--
    $button => array // ['title', 'link', 'excerpt', 'secondary_relative_url']
--}}

@if(!empty($button['link']) && !empty($button['secondary_relative_url']))
    <a href="{{ $button['link'] }}" class="content-button block min-w-full relative rounded bg-grey-lighter hover:bg-grey-lightest overflow-hidden">
        <div class="min-w-full flex p-3 xl:p-4 @if(!empty($button['excerpt'])) items-top @else items-center @endif">
            <div class="w-1/6">
                @image($button['secondary_relative_url'], $button['secondary_alt_text'], 'block')
            </div>
            <div class="w-5/6 pl-2 xl:pl-4">
                <div class="block text-xl font-bold text-black leading-tight">{{ $button['title'] }}</div>
                @if(!empty($button['excerpt']))
                    <div class="leading-tight text-sm text-black pb-1">{{ $button['excerpt'] }}</div>
                @endif
            </div>
        </div>
    </a>
@endif
