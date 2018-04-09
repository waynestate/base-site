@extends('partials.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="content">
        {!! $page['content']['main'] !!}
    </div>

    @forelse($profiles as $key => $profiles)
        <h1>{{ $key }}</h1>

        <div class="row small-up-2 medium-up-3">
            @foreach($profiles as $profile)
                <div class="column profile">
                    <a href="/{{ ($site['subsite-folder'] !== null) ? $site['subsite-folder'] : '' }}profile/{{ $profile['data']['AccessID'] }}" class="profile-img" style="background-image: url('{{ $profile['data']['Picture']['url'] ?? '/_resources/images/no-photo.svg' }}');">
                        <span class="visuallyhidden">{{ $profile['data']['First Name'] }} {{ $profile['data']['Last Name'] }}</span>
                    </a>
                    <a href="/{{ ($site['subsite-folder'] !== null) ? $site['subsite-folder'] : '' }}profile/{{ $profile['data']['AccessID'] }}">{{ $profile['data']['First Name'] }} {{ $profile['data']['Last Name'] }}</a>

                    @if(isset($profile['data']['Title']))
                        <span>{{ $profile['data']['Title'] }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    @empty
        <p>No profiles found.</p>
    @endforelse
@endsection
