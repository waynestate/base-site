@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    <div class="row flex flex-wrap -mx-4">
        <div class="w-full lg:w-1/3 px-4 mt-6">
            @if(!empty($profile['data']['Picture']['url']))
                <img src="{{ $profile['data']['Picture']['url'] }}" alt="{{ $base['page']['title'] }}" class="sm:h-64 lg:h-auto mx-auto lg:mx-0 block mb-4">
            @else
                <img src="/_resources/images/no-photo.svg" alt="{{ $base['page']['title'] }}" class="sm:h-64 lg:h-auto block mx-auto lg:mx-0 mb-4">
            @endif

            @include('components.page-title', ['title' => $base['page']['title'], 'class' => 'block lg:hidden'])

            <div class="content">
                @if(!empty($profile['data']['Title']))
                    <p>{!! strip_tags($profile['data']['Title'], '<br>') !!}</p>
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

                @if(!empty($profile['data']['Youtube Videos']))
                    @foreach ($profile['data']['Youtube Videos'] as $item)
                        <div class="pb-4">
                            @include('components.video-profile', ['video' =>  $item])
                        </div>
                    @endforeach
                @endif
             </div>
        </div>

        <div class="w-full lg:w-2/3 px-4">
            @include('components.page-title', ['title' => $base['page']['title'], 'class' => 'hidden lg:block'])

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

                @if(!empty($courses))
                    <h2>Courses taught by {{ $base['page']['title'] }}</h2>
                    @foreach($courses as $semester => $course_list)
                        <h3>{{ $semester }}</h3>
                        <ul>
                        @foreach($course_list as $course)
                            <li>
                                <a href="https://bulletins.wayne.edu/search/?q={{ $course['short_code'] }}+{{ $course['course_number'] }}">{{ $course['short_code'] }}{{ $course['course_number'] }} - {{ $course['course_name'] }}</a>
                            </li>
                        @endforeach
                        </ul>
                    @endforeach
                @endif

                @if(!empty($articles))
                    <h2>Recent university news spotlights</h2>
                    <ul>
                        @foreach($articles as $article)
                            <li>
                                <a
                                    href="{{ $article['link'] }}"
                                >
                                    {{ $article['title'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if($back_url != '')
                    <p class="pt-4 print:hidden">
                        <a href="{{ $back_url }}" class="button">&larr; Return to listing</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
