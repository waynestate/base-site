<ul class="grid gap-4 {{ !empty($component['columns']) && $component['columns'] % 2 == 0 ? (count($data) >= 4 ? ' sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-'.($component['columns']) : ' md:grid-cols-'.$component['columns']) : (count($data) >= 3 ? ' sm:grid-cols-1 md:grid-cols-3' : ' md:grid-cols-'.$component['columns']) }}"> 
    @if(!empty($data))
        @foreach($data as $item)
            <li>
                <a href="{{$item['url']}}" class="block w-full group">
                    <div class="w-full">
                        <img data-src="{{$item['display_image']['full_url']}}" alt="{{($item['display_image']['description']) ? $item['display_image']['description'] : ''}}" class="lazy" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==">
                    </div>
                    <div class="mt-2 font-bold">
                        @if(!empty($item['date']))
                            <div class="text-sm uppercase mb-1">{{ date('F j', strtotime($item['date'])) }}</div>
                        @endif
                        <div class="group-hover:underline">{{$item['title']}}</div>
                    </div>
                </a>
            </li>
        @endforeach
    @endif
</ul>
@if(!empty($component['cal_name']) || !empty($base['site']['events']['path']))
    <div class="text-center mt-6">
        <a class="button" href="//events.wayne.edu/{{ $component['cal_name'] ?? $base['site']['events']['path'] }}upcoming">{{ $component['link_text'] ?? 'More events' }}</a>
    </div>
@endif
