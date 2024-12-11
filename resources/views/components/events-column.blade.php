{{--
    $events => array // ['title', 'url', 'date', 'start_time', 'is_all_day']
    $link_text => string // 'More events'
--}}
<ul>
    @if(!empty($data))
        @foreach($data as $events => $event)
            @if($events === 'filtered_by_title')
                @foreach($event as $item)
                    <li class="flex -mx-2">
                        <div class="mx-2">
                            <div class="relative border-2 border-green rounded-sm text-center mb-4">
                                <div class="w-12 bg-green text-white leading-none border-b-2 border-green text-sm">{{ apdatetime(date('M' , strtotime($item['date']))) }}</div>
                                <div class="text-green text-2xl leading-tight">{{ apdatetime(date('j' , strtotime($item['date']))) }}</div>
                            </div>
                        </div>

                        <div class="mx-2">
                            <div class="mb-2 pb-2 border-b border-solid border-gray-300">
                                <a class="block hover:underline" href="{{ $item['url'] }}">{{ $item['title'] }}
                                    <span class="visually-hidden"> on {{ apdatetime(date('M d, Y' , strtotime($item['date']))) }}
                                        @if(!(bool)$item['is_all_day']) at {{ apdatetime(date('g:i a' , strtotime($item['start_time']))) }}@endif
                                    </span>
                                </a>
                                <time class="text-sm text-gray-500" datetime="{{ $item['date'] }}T{{ $item['start_time'] }}{{ date('P') }}">
                                    @if(!(bool)$item['is_all_day']){{ apdatetime(date('g:i a' , strtotime($item['start_time']))) }}@else All day @endif
                                </time>
                            </div>
                        </div>
                    </li>
                @endforeach
            @else
                @foreach($event as $item)
                    <li class="flex -mx-2">
                        @if($loop->first)
                            <div class="mx-2">
                                <div class="relative border-2 border-green rounded-sm text-center mb-4">
                                    <div class="w-12 bg-green text-white leading-none border-b-2 border-green text-sm">{{ apdatetime(date('M' , strtotime($events))) }}</div>
                                    <div class="text-green text-2xl leading-tight">{{ apdatetime(date('j' , strtotime($events))) }}</div>
                                </div>
                            </div>
                        @endif

                        <div class="mx-2 grow{{ ! $loop->first ? ' ml-19' :'' }}">
                            <div class="mb-2 pb-2 border-b border-solid border-gray-300">
                                <a class="block hover:underline" href="{{ $item['url'] }}">{{ $item['title'] }}
                                    <span class="visually-hidden"> on {{ apdatetime(date('M d, Y' , strtotime($events))) }}
                                        @if(!(bool)$item['is_all_day']) at {{ apdatetime(date('g:i a' , strtotime($events))) }}@endif
                                    </span>
                                </a>
                                <time class="text-sm text-gray-500" datetime="{{ $item['date'] }}T{{ $item['start_time'] }}{{ date('P') }}">
                                    @if(!(bool)$item['is_all_day']){{ apdatetime(date('g:i a' , strtotime($item['start_time']))) }}@else All day @endif
                                </time>
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        @endforeach
    @endif
</ul>
@if(!empty($component['cal_name']) || !empty($base['site']['events']['path']))
    <div class="mt-4">
        <a class="button" href="//events.wayne.edu/{{ $component['cal_name'] ?? $base['site']['events']['path'] }}upcoming">{{ $component['link_text'] ?? 'More events' }}</a>
    </div>
@endif
