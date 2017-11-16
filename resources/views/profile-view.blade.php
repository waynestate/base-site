@extends('partials.content-area')

@section('content')
    @if($back_url != '')
        <div class="row profile__return">
            <div class="columns small-12">
                <a href="{{ $back_url }}">&lt; Return to listing</a>
            </div>
        </div>
    @endif

    <div class="row profile__block">
        <div class="small-12 large-4 xlarge-3 columns">
            @if(isset($profile['data']['Picture']['url']))
                <img src="{{ $profile['data']['Picture']['url'] }}" alt="{{ $page['title'] }}" class="profile__img">
            @else
                <img src="/_resources/images/no-photo.svg" alt="{{ $page['title'] }}" class="profile__img">
            @endif

            <h1 class="hide-for-large page-title">{{ $page['title'] }}</h1>

            <div class="profile--contact-info">
                @if(isset($profile['data']['Title']))
                    <p class="title">{{ $profile['data']['Title'] }}</p>
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

        <div class="small-12 large-8 xlarge-9 columns">
            <h1 class="page-title show-for-large">{{ $page['title'] }}</h1>

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
@endsection
