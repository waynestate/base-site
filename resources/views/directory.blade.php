@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>

    @if(!empty($profiles))
        @forelse($profiles as $key => $profiles)
            <h2>{{ $key }}</h2>

            <div class="row flex flex-wrap -mx-4">
                @foreach($profiles as $profile)
                    <div class="w-full sm:w-1/2 md:w-1/3 xl:w-1/4 px-4 pb-6">
                        <a href="{{ $profile['link'] }}" class="underline hover:no-underline">
                            <div class="block bg-cover bg-center w-full pt-portrait lazy mb-1" data-src="{{ $profile['data']['Picture']['url'] ?? '/_resources/images/no-photo.svg' }}"></div>
                            <span class="font-bold">{{ $profile['data']['First Name'] }} {{ $profile['data']['Last Name'] }}</span>
                        </a>

                        @if(!empty($profile['data']['Title']))
                            <span class="block text-sm">{{ $profile['data']['Title'] }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @empty
            <p>No profiles found.</p>
        @endforelse
    @else
        <p>No profiles found.</p>
    @endif
@endsection
