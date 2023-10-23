{{--
    $events => array // ['title', 'url', 'date', 'start_time', 'is_all_day']
    $link_text => string // 'More events'
--}}

<div class="col-span-2 md:col-span-1">
    @if(!empty($data[0]['component']['heading']))<h2 class="mt-0">{{ $data[0]['component']['heading'] }}</h2>@endif

    <ul>
        @foreach($data as $key => $dates)
            @foreach($dates as $key => $event)
                @if($key != 'component')
                    <li class="flex -mx-2">
                        @if($loop->first)
                            <div class="mx-2">
                                <div class="relative border-2 border-green rounded-sm text-center mb-4">
                                    <div class="w-12 bg-green text-white leading-none border-b-2 border-green text-sm">{{ apdatetime(date('M' , strtotime($key))) }}</div>
                                    <div class="text-green text-2xl leading-tight">{{ apdatetime(date('j' , strtotime($key))) }}</div>
                                </div>
                            </div>
                        @endif

                        <div class="mx-2 grow{{ ! $loop->first ? ' ml-19' :'' }}">
                            <div class="mb-2 pb-2 border-b border-solid border-gray-300">
                                <a class="block hover:underline" href="{{ $event['url'] }}">{{ $event['title'] }}
                                    <span class="visually-hidden"> on {{ apdatetime(date('M d, Y' , strtotime($key))) }}
                                        @if(!(bool)$event['is_all_day']) at {{ apdatetime(date('g:i a' , strtotime($event['start_time']))) }}@endif
                                    </span>
                                </a>
                                <time class="text-sm text-gray-500" datetime="{{ $event['date'] }}T{{ $event['start_time'] }}{{ date('P') }}">
                                    @if(!(bool)$event['is_all_day']){{ apdatetime(date('g:i a' , strtotime($event['start_time']))) }}@else All day @endif
                                </time>
                            </div>
                        </div>
                    </li>
                @endif
            @endforeach
            @if($dates == end($data))
                <li class="flex -mx-2 ml-17">
                    <a href="//events.wayne.edu/{{ $dates[0]['calendar_url'] ?? 'main/' }}month/" class="hover:underline">{{ $link_text ?? 'More events' }}</a>
                </li>
            @endif
        @endforeach
    </ul>
</div>
