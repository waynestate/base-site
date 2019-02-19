{{--
    $contact => array // [['title', 'link', 'description']]
--}}
@if(is_array($contact) && count($contact) > 0)
    <div class="bg-green">
        <div class="row flex flex-wrap lg:flex-no-wrap py-8 @if(count($contact) == 1)text-center @endif">
            @foreach($contact as $info)
                @if($loop->iteration == 1)
                    <div class="w-full px-4 py-4 lg:flex-1">
                        <h2 class="text-yellow-light mb-1">
                            @if($info['link'] != '')
                                <a href="{{ $info['link'] }}" class="text-yellow-light">{{ $info['title'] }}</a>
                            @else
                                {{ $info['title'] }}
                            @endif
                        </h2>

                        <div class="content text-white">
                            {!! $info['description'] !!}
                        </div>
                    </div>
                @else
                    <div class="w-full lg:flex-1 px-4 py-4 text-white content border-t lg:border-l lg:border-0 border-grey">
                        {!! $info['description'] !!}
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif
