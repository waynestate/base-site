{{--
    $contact => array // [['title', 'link', 'description']]
--}}
@if(is_array($contact) && count($contact) > 0)
    <div class="bg-green">
        @if(count($contact) == 1)
            <div class="row text-center py-8">
                @foreach($contact as $info)
                    <h2 class="text-yellow-light">
                        @if($info['link'] != '')<a href="{{ $info['link'] }}" class="text-yellow">@endif
                        {{ $info['title'] }}
                        @if($info['link'] != '')</a>@endif
                    </h2>

                    <div class="p-6 text-white">
                        {!! $info['description'] !!}
                    </div>
                @endforeach
            </div>
        @else
            <div class="row flex flex-wrap py-8">
                @foreach($contact as $info)
                <div class="w-full sm:w-1/3 px-4 py-4 text-white {{ $loop->last !== true ? 'border-b sm:border-r sm:border-0 border-grey sm:pl-6' : '' }}">
                        {!! $info['description'] !!}
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endif
