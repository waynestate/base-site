{{--
    $events => array // ['title', 'url', 'date', 'start_time', 'is_all_day']
    $cal_name => string // 'main/'
    $link_text => string // 'More events'
    $button_class => string // 'green-gradient-button'
--}}
<ul class="grid gap-8 {{ !empty($component['columns']) && $component['columns'] % 2 == 0 ? ($component['columns'] >= 4 ? ' grid-cols-2' : ' sm-grid-cols-2').' md:grid-cols-3 xl:grid-cols-'.($component['columns']) : ' sm:grid-cols-2 md:grid-cols-3' }}"> 
    @foreach($data as $key => $event)
        <li class="flex items-start break-avoid mb-6">
            <div class="flex-shrink-0 mt-1 border-2 border-green rounded-sm text-center">
                <div class="w-12 bg-green text-white leading-none border-b-2 border-green text-sm">{{ apdatetime(date('M' , strtotime($event['date']))) }}</div>
                <div class="text-green text-2xl leading-tight">{{ apdatetime(date('j' , strtotime($event['date']))) }}</div>
            </div>

            <div class="ml-4 flex-grow">
                <a class="mt-0 block hover:underline" href="{{ $event['url'] }}">
                    {{ $event['title'] }}
                    <span class="visually-hidden"> on {{ apdatetime(date('M d, Y' , strtotime($event['date']))) }}
                        @if(!(bool)$event['is_all_day']) at {{ apdatetime(date('g:i a' , strtotime($event['start_time']))) }}@endif
                    </span>
                </a>
                <time class="text-sm text-gray-500" datetime="{{ $event['date'] }}T{{ $event['start_time'] }}{{ date('P') }}">
                    @if(!(bool)$event['is_all_day']){{ apdatetime(date('g:i a' , strtotime($event['start_time']))) }}@else All day @endif
                </time>
            </div>
        </li>
    @endforeach
</ul>

@if(!empty($component['cal_name']) || !empty($base['site']['events']['path']))
    <div class="text-center mt-6">
        <a class="button" href="//events.wayne.edu/{{ $component['cal_name'] ?? $base['site']['events']['path'].'main/' }}upcoming">{{ $component['link_text'] ?? 'More events' }}</a>
    </div>
@endif
