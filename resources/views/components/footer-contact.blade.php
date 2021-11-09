{{--
    $contact => array // ['title', 'link', 'description']
--}}
@if(is_array($contact) && count($contact) > 0)
    <div class="bg-green-700 print:bg-transparent">
        <div class="row flex flex-wrap lg:flex-no-wrap py-8 print:py-0">
            @foreach($contact as $info)
                @if($loop->iteration == 1)
                    <div class="w-full px-4 py-4 lg:flex-1">
                        <h2 class="text-gold-300 mb-1 print:text-black">{{ $info['title'] }}</h2>
                        <div>
                            <div class="content white-links text-white print:text-black">
                                {!! $info['description'] !!}
                            </div>

                            @if(!empty($base['social']))
                                @include('components.footer-social2', ['social' => $base['social']])
                            @endif
                        </div>
                    </div>
                @else
                    <div class="w-full lg:flex-1 px-4 py-4 border-t lg:border-l lg:border-0 border-green-300">
                        <div class="content white-links text-white print:text-black">
                            {!! $info['description'] !!}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif
