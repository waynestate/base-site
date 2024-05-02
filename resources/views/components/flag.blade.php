{{--
    $flag => array // [['title', 'link', 'excerpt']]
--}}
<div class="row relative">
    <a class="flag" href="{{ $flag['link'] }}">
        <span class="flag__title">{{ $flag['title'] }}</span>
        @if($flag['excerpt'] != '')
            <span class="flag__excerpt">{{ $flag['excerpt'] }}</span>
        @endif
    </a>
</div>
