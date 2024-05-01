{{--
    $flag => array // [['title', 'link', 'excerpt']]
--}}
<div class="flag__container {{ $class ?? '' }}">
    <a class="flag" href="{{ $flag['link'] }}">
        <span class="flag__title">{!! $flag['title'] !!}</span>
        @if(!empty($flag['excerpt']))
            <span class="flag__excerpt">{{ $flag['excerpt'] }}</span>
        @endif
    </a>
</div>
