{{--
    $social => array // [['title','link']]
--}}
@if(is_array($social))
    <div class="footer-social">
        <div class="row">
            <div class="small-12 text-center columns">
                <ul>
                    @foreach($social as $item)
                        <li>
                            <a href="{{ $item['link'] }}" target="_blank" rel="noopener">
                                <i class="icon-{{ strtolower($item['title']) }}"><span>{{ $item['title'] }}</span></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
