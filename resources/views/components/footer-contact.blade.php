{{--
    $contact => array // ['title', 'link', 'description']
--}}
@if(is_array($contact) && count($contact) > 0)
    <div class="bg-green-600">
        <div class="row lg:grid grid-cols-{{ count($contact)}} py-8">
            @foreach($contact as $info)
                @if($loop->iteration == 1)
                    <div class="p-4 @if(count($contact) == 1)text-center @endif">
                        <h2 class="text-gold-300 mb-1 print:text-black">{{ $info['title'] }}</h2>
                        <div class="content white-links text-white print:text-black">
                            {!! $info['description'] !!}
                        </div>
                    </div>
                @else
                    <div class="px-4 py-4 border-t lg:border-l lg:border-0 border-green-500">
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
