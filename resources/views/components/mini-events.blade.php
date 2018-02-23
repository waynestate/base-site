{{--
    $events => array // [['title', 'url', 'date', 'start_time', 'is_all_day']]
    $heading => string // 'Events'
    $cal_name => string // 'main'
    $link_text => string // 'More events'
--}}
<h2>{{ $heading or 'Events' }}</h2>

<dl class="listing events">
    @foreach($events as $event)
        <dt><a href="{{ $event['url'] }}">{{ $event['title'] }}</a></dt>
        <dd>
            <time datetime="{{ apdatetime($event['date']) }} {{ apdatetime($event['start_time']) }}">
                {{ apdatetime(date("F j, Y", strtotime($event['date']))) }}
                @if(!(bool)$event['is_all_day'])
                    at {{ apdatetime(date('g:i a' , strtotime($event['start_time']))) }}
                @endif
            </time>
        </dd>
    @endforeach
</dl>

<a href="//events.wayne.edu/{{ $cal_name or 'main' }}/month/" class="more-link">{{ $link_text or 'More events' }}</a>
