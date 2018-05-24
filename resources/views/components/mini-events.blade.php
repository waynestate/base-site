{{--
    $events => array // [['title', 'url', 'date', 'start_time', 'is_all_day']]
    $heading => string // 'Events'
    $cal_name => string // 'main'
    $link_text => string // 'More events'
--}}
<h2>{{ $heading ?? 'Events' }}</h2>

<dl>
    @foreach($events as $event)
        <dt><a href="{{ $event['url'] }}" class="underline hover:no-underline">{{ $event['title'] }}</a></dt>
        <dd class="mb-4">
            <time class="text-grey-darker text-sm" datetime="{{ apdatetime($event['date']) }} {{ apdatetime($event['start_time']) }}">
                {{ apdatetime(date("F j, Y", strtotime($event['date']))) }}
                @if(!(bool)$event['is_all_day'])
                    at {{ apdatetime(date('g:i a' , strtotime($event['start_time']))) }}
                @endif
            </time>
        </dd>
    @endforeach
</dl>

<a href="//events.wayne.edu/{{ $cal_name ?? 'main' }}/month/" class="block my-4 underline hover:no-underline">{{ $link_text ?? 'More events' }}</a>
