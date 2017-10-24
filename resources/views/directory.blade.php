@extends('partials.content-area')

@section('content')
    <h1 class="page-title">{{ $page['title'] }}</h1>

    {!! $page['content']['main'] !!}

    @foreach($profiles as $key => $profiles)
        <h1>{{ $key }}</h1>

        <div class="row small-up-2 medium-up-3">
            @forelse((array)$profiles as $profile)
                <div class="columns profile">
                    <a href="/{{ ($site['subsite-folder'] !== null) ? $site['subsite-folder'] : '' }}profile/{{ $profile['data']['AccessID'] }}" class="profile-img" style="background-image: url('{{ $profile['data']['Picture']['url'] or '/_resources/images/no-photo.svg' }}');" alt="{{ $profile['data']['First Name'] }} {{ $profile['data']['Last Name'] }}"></a>
                    <a href="/{{ ($site['subsite-folder'] !== null) ? $site['subsite-folder'] : '' }}profile/{{ $profile['data']['AccessID'] }}">{{ $profile['data']['First Name'] }} {{ $profile['data']['Last Name'] }}</a>

                    @if(isset($profile['data']['Title']))
                        <span>{{ $profile['data']['Title'] }}</span>
                    @endif
                </div>
            @empty
                <p>No profiles found.</p>
            @endforelse
        </div>
    @endforeach
@endsection
