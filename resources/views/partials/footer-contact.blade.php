{{--
    $contact => array // [['title', 'link', 'description']]
--}}
@if(is_array($contact) && count($contact) > 0)
    <div class="footer-contact">
        @if(count($contact) == 1)
            <div class="row">
                <div class="columns small-12 text-center">
                    @foreach($contact as $info)
                        <h2>
                            @if($info['link'] != '')<a href="{{ $info['link'] }}">@endif
                            {{ $info['title'] }}
                            @if($info['link'] != '')</a>@endif
                        </h2>

                        {!! $info['description'] !!}
                    @endforeach
                </div>
            </div>
        @else
            <div class="row" data-equalizer>
                @foreach($contact as $info)
                    <div class="columns small-12 large-4{{ ($info == end($contact)) ? ' end' : '' }}" data-equalizer-watch>
                        {!! $info['description'] !!}

                        <hr />
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endif
