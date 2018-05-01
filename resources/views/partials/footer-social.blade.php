{{--
    $social => array // [['title','link']]
--}}
<div class="footer-social">
    <ul class="row text-center">
        @foreach($social as $item)
            <li>
                <a href="{{ $item['link'] }}" target="_blank" rel="noopener">
                    <span class="icon-{{ strtolower($item['title']) }}"></span><p class="visually-hidden">{{ $item['title'] }}</p>
                </a>
            </li>
        @endforeach
    </ul>
</div>
