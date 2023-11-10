{{--
    $topics => array // ['url', 'name', 'selected']
    $heading => string // 'Filter by topic'
    $class => string // ''
--}}
<h2 class="{!! !empty($class) ? $class : 'text-lg m-0 pt-4' !!}">{{ $heading }}</h2>

<ul class="main-menu pt-0">
    @foreach($topics as $topic)
        <li{!! !empty($topic['selected']) ? ' class="selected"': '' !!}><a href="{{ $topic['url'] }}">{{ $topic['name'] }}</a></li>
    @endforeach
</ul>
