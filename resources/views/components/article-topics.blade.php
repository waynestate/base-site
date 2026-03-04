{{--
    $topics => array // ['url', 'name', 'selected']
    $heading => string // 'Filter by topic'
    $class => string // ''
--}}
<div @class($class ?? 'text-lg m-0 pt-4 font-bold')>{{ $heading }}</div>

<ul class="main-menu pt-0">
    @foreach($topics as $topic)
        <li{!! !empty($topic['selected']) ? ' class="selected"': '' !!}><a href="{{ $topic['url'] }}">{{ $topic['name'] }}</a></li>
    @endforeach
</ul>
