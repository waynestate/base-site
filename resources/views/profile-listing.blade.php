@extends('partials.content-area')

@section('content')
    <h1 class="page-title">{{ $page['title'] }}</h1>

    @if($hide_filtering == false)
        <form name="programs" method="get" class="filter">
            <div class="row">
                <div class="large-12 columns">
                    <label for="program">View by department:</label>
                    <div class="row collapse">
                        <div class="small-10 columns">
                            <select name="group">
                                @foreach($dropdown_groups as $key=>$value)
                                    <option value="{{ $key }}"@if($key == $selected_group) selected="selected"@endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="small-2 columns">
                            <input type="submit" value="Filter" class="postfix button" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif

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
@endsection
