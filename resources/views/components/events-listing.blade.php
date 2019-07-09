{{--
    $events => array // ['title', 'url', 'date', 'start_time', 'is_all_day']
    $heading => string // 'Events'
    $cal_name => string // 'main/'
    $link_text => string // 'More events'
--}}
<h2{!! !empty($class) ? ' class="'.$class.'"' : '' !!}>{{ $heading ?? 'Events' }}</h2>

<ul>
    @foreach($events as $key => $dates)
        <li class="flex -mx-2">
            <div class="mx-2">
                <div class="relative border-2 border-green rounded-sm text-center mb-4">
                    <div class="w-12 bg-green text-white leading-none border-b-2 border-green text-sm">{{ apdatetime(date('M' , strtotime($key))) }}</div>
                    <div class="text-green text-2xl leading-tight">{{ apdatetime(date('j' , strtotime($key))) }}</div>
                </div>
            </div>
            <div class="mx-2 flex-grow">
                @foreach($dates as $event)
                    <div class="mb-2 pb-2 border-b border-solid border-grey-light">
                        <a class="block hover:underline" href="{{ $event['url'] }}">{{ $event['title'] }}
                            <span class="visually-hidden"> on {{ apdatetime(date('M d, Y' , strtotime($key))) }}
                                @if(!(bool)$event['is_all_day']) at {{ apdatetime(date('g:i a' , strtotime($event['start_time']))) }}@endif
                            </span>
                        </a>
                        <time class="text-sm text-grey-darker" datetime="{{ $event['date'] }}T{{ $event['start_time'] }}{{ date('P') }}">
                            @if(!(bool)$event['is_all_day']){{ apdatetime(date('g:i a' , strtotime($event['start_time']))) }}@else All day @endif
                        </time>
                    </div>
                @endforeach
                @if($dates == end($events))
                    <div>
                        <a href="//events.wayne.edu/{{ $cal_name ?? 'main/' }}month/" class="hover:underline">{{ $link_text ?? 'More events' }}</a>
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
