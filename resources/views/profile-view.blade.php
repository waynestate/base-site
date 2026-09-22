@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    <div class="row flex flex-wrap -mx-4">
        <div class="w-full lg:w-1/3 px-4 mt-6">
            @if(!empty($profile['data']['Picture']['url']))
                <img src="{{ $profile['data']['Picture']['url'] }}" alt="{{ $base['page']['title'] }}" class="sm:h-64 lg:h-auto mx-auto lg:mx-0 block mb-4">
            @else
                <img src="/_resources/images/no-photo.svg" alt="{{ $base['page']['title'] }}" class="sm:h-64 lg:h-auto block mx-auto lg:mx-0 mb-4">
            @endif

            @include('partials.page-title', ['title' => $base['page']['title'], 'class' => 'block lg:hidden'])

            <div class="content">
                @if(!empty($profile['data']['Title']))
                    @include('components.profile-field', ['field' => 'Title', 'data' => $profile['data']['Title'], 'tag' => 'p'])
                @endif

                @foreach($profile['data'] as $field=>$data)
                    @if(in_array($field, $contact_fields))
                        @include('components.profile-field', ['field' => $field, 'data' => $data, 'tag' => 'p'])
                    @endif
                @endforeach

                @if(!empty($profile['data']['Youtube Videos']))
                    @include('components.profile-field', ['field' => 'Youtube Videos', 'data' => $profile['data']['Youtube Videos']])
                @endif
             </div>
        </div>

        <div class="w-full lg:w-2/3 px-4">
            @include('partials.page-title', ['title' => $base['page']['title'], 'class' => 'hidden lg:block'])

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
