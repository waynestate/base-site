{{--
    $contact => array // ['title', 'link', 'description']
--}}
@if(is_array($contact) && count($contact) > 0)
    <div class="bg-green-600">
        <div class="row flex flex-wrap lg:flex-no-wrap py-8 print:py-0">
            @foreach($contact as $info)
                @if($loop->iteration == 1)
                    <div class="w-full px-4 py-4 lg:flex-1 text-center">
                        <h2 class="text-gold-300 mb-1 print:text-black">{{ $info['title'] }}</h2>
                        <div class="content white-links text-white print:text-black">
                            {!! $info['description'] !!}
                        </div>
                    </div>
                @else
                    <div class="w-full lg:flex-1 px-4 py-4 border-t lg:border-l lg:border-0 border-green-500">
                        <h3 class="text-gold-300 mb-1 text-2xl">{{ $info['title'] }}</h2>
                        <div class="content white-links text-white print:text-black">
                            {!! $info['description'] !!}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif
