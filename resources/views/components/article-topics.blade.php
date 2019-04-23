<h2{!! !empty($class) ? ' class="'.$class.'"' : '' !!}>{{ $heading }}</h2>

<ul>
    @foreach($topics as $topic)
        <li{!! !empty($topic['selected']) ? ' class="selected"': '' !!}><a href="{{ $topic['url'] }}">{{ $topic['name'] }}</a></li>
    @endforeach
</ul>
