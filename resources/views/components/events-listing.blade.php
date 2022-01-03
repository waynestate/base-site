{{--
    $events => array // ['title', 'url', 'date', 'start_time', 'is_all_day']
    $cal_name => string // 'main/'
    $link_text => string // 'More events'
    $button_class => string // 'green-gradient-button'
--}}

<ul class="my-4">
    @foreach($events as $key => $dates)
    <li class="flex mb-2">
        <div class="flex-shrink-0">
            <div class="mt-1 border-2 border-green rounded-sm text-center">
                <div class="w-12 bg-green text-white leading-none border-b-2 border-green text-sm">{{ apdatetime(date('M' , strtotime($key))) }}</div>
                <div class="text-green text-2xl leading-tight">{{ apdatetime(date('j' , strtotime($key))) }}</div>
            </div>
        </div>

        <div class="ml-4 flex-grow">
            @foreach($dates as $event)
                <div class="mb-4">
                    <a class="block hover:underline" href="{{ $event['url'] }}">{{ $event['title'] }}
                        <span class="visually-hidden"> on {{ apdatetime(date('M d, Y' , strtotime($key))) }}
                            @if(!(bool)$event['is_all_day']) at {{ apdatetime(date('g:i a' , strtotime($event['start_time']))) }}@endif
                        </span>
                    </a>
                    <time class="text-sm text-gray-500" datetime="{{ $event['date'] }}T{{ $event['start_time'] }}{{ date('P') }}">
                        @if(!(bool)$event['is_all_day']){{ apdatetime(date('g:i a' , strtotime($event['start_time']))) }}@else All day @endif
                    </time>
                </div>
            @endforeach
        </div>
    </li>
    @endforeach
</ul>

<div class="mt-4">
    <a class="button {{ $button_class ?? '' }}" href="//events.wayne.edu/{{ $cal_name ?? 'main/' }}month/" class="hover:underline">
        {{ $link_text ?? 'More events' }}
    </a>
</div>
