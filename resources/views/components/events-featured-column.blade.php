<ul>
    @if(!empty($data['filtered_by_title']))
        @foreach($data['filtered_by_title'] as $key => $event)
            <li class="mb-6">
                <a href="{{$event['url']}}" class="flex w-full group">
                    <div class="w-1/3 shrink-0">
                        <img data-src="{{$event['display_image']['full_url']}}" alt="{{($event['display_image']['description']) ? $event['display_image']['description'] : ''}}" class="lazy" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==">
                    </div>
                    <div class="ml-4 pt-3 font-bold">
                        @if(!empty($event['date']))
                            <div class="text-sm uppercase mb-1">{{ date('F j', strtotime($event['date'])) }}</div>
                        @endif
                        <div class="group-hover:underline">{{$event['title']}}</div>
                    </div>
                </a>
            </li>
        @endforeach
    @else
        @foreach($data as $key => $event)
            <li class="mb-6">
                <a href="{{$event['url']}}" class="flex w-full group">
                    <div class="w-1/3 shrink-0">
                        <img data-src="{{$event['display_image']['full_url']}}" alt="{{($event['display_image']['description']) ? $event['display_image']['description'] : ''}}" class="lazy" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==">
                    </div>
                    <div class="ml-4 pt-3 font-bold">
                        @if(!empty($event['date']))
                            <div class="text-sm uppercase mb-1">{{ date('F j', strtotime($event['date'])) }}</div>
                        @endif
                        <div class="group-hover:underline">{{$event['title']}}</div>
                    </div>
                </a>
            </li>
        @endforeach
    @endif
</ul>
@if(!empty($component['cal_name']) || !empty($base['site']['events']['path']))
    <div class="mt-4">
        <a class="button" href="//events.wayne.edu/{{ $component['cal_name'] ?? $base['site']['events']['path'] }}upcoming">{{ $component['link_text'] ?? 'More events' }}</a>
    </div>
@endif
