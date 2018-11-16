{{--
    $events => array // [['title', 'url', 'date', 'start_time', 'is_all_day']]
    $heading => string // 'Events'
    $cal_name => string // 'main'
    $link_text => string // 'More events'
--}}
<h2>{{ $heading ?? 'Events' }}</h2>

<ul class="list-reset">
    @foreach($events as $key => $dates)
        <li class="flex -mx-2">
            <div class="mx-2">
                <div class="relative border-2 border-green rounded-sm text-center mb-4">
                    <div class="w-12 bg-green text-white leading-none border-b-2 border-green text-sm">{{ apdatetime(date('M' , strtotime($key))) }}</div>
                    <div class="text-green text-2xl leading-tight">{{ apdatetime(date('d' , strtotime($key))) }}</div>
                </div>
            </div>
            <ul class="list-reset mx-2">
                @foreach($dates as $event)
                    <li class="mb-2 pb-2 border-b border-solid">
                        <a class="block" href="{{ $event['url'] }}">{{ $event['title'] }}</a>
                        <time class="text-sm text-grey-darker" datetime="{{ $event['date'] }}T{{ $event['start_time'] }}{{ date('P') }}">
                            @if(!(bool)$event['is_all_day']){{ apdatetime(date('g:i a' , strtotime($event['start_time']))) }}@else All day @endif
                        </time>
                    </li>
                @endforeach
                @if($dates == end($events))
                    <li>
                        <a href="//events.wayne.edu/{{ $cal_name ?? 'main' }}/month/">{{ $link_text ?? 'More events' }}</a>
                    </li>
                @endif
            </ul>
        </li>
    @endforeach
</ul>
