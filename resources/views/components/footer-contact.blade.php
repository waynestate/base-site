{{--
    $contact => array // [['title', 'link', 'description']]
--}}
@if(is_array($contact) && count($contact) > 0)
    <div class="bg-green">
        @if(count($contact) == 1)
            <div class="row text-center py-8">
                @foreach($contact as $info)
                    <h2 class="text-yellow-light">
                        @if($info['link'] != '')<a href="{{ $info['link'] }}" class="text-yellow-light">@endif
                        {{ $info['title'] }}
                        @if($info['link'] != '')</a>@endif
                    </h2>

                    <div class="p-6 text-white content">
                        {!! $info['description'] !!}
                    </div>
                @endforeach
            </div>
        @else
            <div class="row flex flex-wrap py-8">
                @foreach($contact as $info)
                    <div class="w-full md:w-1/3 px-4 py-4 text-white content {{ $loop->last !== true ? 'border-b md:border-r md:border-0 border-grey' : '' }}">
                        {!! $info['description'] !!}
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endif
