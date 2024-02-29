<ul>
    @if(!empty($data))
        @foreach($data as $item)
            <li class="mb-6">
                <a href="{{$item['url']}}" class="flex w-full group">
                    <div class="w-1/3 shrink-0">
                        <img data-src="{{$item['display_image']['full_url']}}" alt="{{($item['display_image']['description']) ? $item['display_image']['description'] : ''}}" class="lazy" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==">
                    </div>
                    <div class="ml-4 pt-3 font-bold">
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
    <div class="mt-4">
        <a class="button" href="//events.wayne.edu/{{ $component['cal_name'] ?? $base['site']['events']['path'].'/' }}upcoming">{{ $component['link_text'] ?? 'More events' }}</a>
    </div>
@endif
