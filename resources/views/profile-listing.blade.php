@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    @if($hide_filtering == false)
        <form name="programs" method="get" class="filter formy">
            <label for="filter-group" class="text-black">View by department:</label>
            <div class="row">
                <div class="w-5/6">
                    <select name="group" id="filter-group">
                        @foreach($dropdown_groups as $key=>$value)
                            <option value="{{ $key }}"@if($key == $selected_group) selected="selected"@endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-1/6">
                    <input type="submit" value="Filter" class="postfix button" />
                </div>
            </div>
        </form>
    @endif

    <div class="row flex flex-wrap">
        @forelse($profiles as $profile)
            <div class="w-full sm:w-1/2 md:w-1/3 pr-8 pb-4">
                <a href="/{{ ($site['subsite-folder'] !== null) ? $site['subsite-folder'] : '' }}profile/{{ $profile['data']['AccessID'] }}">
                    <div class="block bg-cover bg-center w-full pt-full lazy" data-src="{{ $profile['data']['Picture']['url'] ?? '/_resources/images/no-photo.svg' }}"></div>
                    {{ $profile['data']['First Name'] }} {{ $profile['data']['Last Name'] }}
                </a>

                @if(isset($profile['data']['Title']))
                    <span class="block text-sm">{{ $profile['data']['Title'] }}</span>
                @endif
            </div>
        @empty
            <p>No profiles found.</p>
        @endforelse
    </div>
@endsection
