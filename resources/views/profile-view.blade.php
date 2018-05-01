@extends('components.content-area')

@section('content')
    @if($back_url != '')
        <div class="profile__return relative">
            <a href="{{ $back_url }}" class="text-right absolute pin-r md:py-1">&lt; Return to listing</a>
        </div>
    @endif

    <div class="row flex flex-wrap profile__block">
        <div class="w-full lg:w-1/3 px-4 mt-6">
            @if(isset($profile['data']['Picture']['url']))
                <img src="{{ $profile['data']['Picture']['url'] }}" alt="{{ $page['title'] }}" class="sm:h-64 md:h-auto block mx-auto">
            @else
                <img src="/_resources/images/no-photo.svg" alt="{{ $page['title'] }}" class="sm:h-64 md:h-auto block mx-auto">
            @endif

            @include('components.page-title', ['title' => $page['title'], 'class' => 'block md:hidden'])

            <div class="content">
                @if(isset($profile['data']['Title']))
                    <p>{{ $profile['data']['Title'] }}</p>
                @endif

                @foreach($profile['data'] as $field=>$data)
                    @if(in_array($field, $contact_fields))
                        @if(in_array($field, $file_fields))
                            <p><a href="{{ $data['url'] }}">{{ $field }}</a></p>
                        @else
                            @if(is_array($data))
                                @foreach($data as $value)
                                    @if(in_array($field, $url_fields))
                                        <p><a href="{{ $value }}">{{ $value }}</a></p>
                                    @else
                                        <p>{{ $value }}</p>
                                    @endif
                                @endforeach
                            @else
                                @if($field == 'Email')
                                    <p><a href="mailto:{{ $data }}">{{ $data }}</a></p>
                                @elseif($field == 'Fax')
                                    <p>{!! strip_tags($data) !!} (fax)</p>
                                @elseif(in_array($field, $url_fields))
                                    <p><a href="{{ $data }}">{{ $data }}</a></p>
                                @else
                                    <p>{!! strip_tags($data) !!}</p>
                                @endif
                            @endif
                        @endif
                    @endif
                @endforeach
             </div>
        </div>

        <div class="w-full lg:w-2/3 px-4">
            @include('components.page-title', ['title' => $page['title'], 'class' => 'hidden md:block'])

            <div class="content">
                @foreach($profile['data'] as $field=>$data)
                    @if(!in_array($field, $contact_fields) && !in_array($field, $hidden_fields))
                        <h2>{{ $field }}</h2>

                        @if(is_array($data))
                            @foreach($data as $value)
                                {!! $value !!}
                            @endforeach
                        @else
                            {!! $data !!}
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
