@extends('partials.content-area')

@section('content')
    <h1 class="page-title">{{ $page['title'] }}</h1>

    @if($hide_filtering == false)
        <form name="programs" method="get" class="filter">
            <div class="row">
                <div class="small-12 columns">
                    <label for="filter-group">View by department:</label>
                    <div class="row collapse">
                        <div class="small-10 columns">
                            <select name="group" id="filter-group">
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
            <div class="column profile">
                <a href="/{{ ($site['subsite-folder'] !== null) ? $site['subsite-folder'] : '' }}profile/{{ $profile['data']['AccessID'] }}">
                    <div class="profile-img" style="background-image: url('{{ $profile['data']['Picture']['url'] or '/_resources/images/no-photo.svg' }}');"></div>
                    {{ $profile['data']['First Name'] }} {{ $profile['data']['Last Name'] }}
                </a>

                @if(isset($profile['data']['Title']))
                    <span>{{ $profile['data']['Title'] }}</span>
                @endif
            </div>
        @empty
            <p>No profiles found.</p>
        @endforelse
    </div>
@endsection
