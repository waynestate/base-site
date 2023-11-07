@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    @if($hide_filtering == false)
        <form name="departments" method="get" class="filter formy mb-6">
            <label for="filter-group" class="text-black block mb-2">View by department:</label>
            <select name="group" id="filter-group">
                @foreach($dropdown_groups as $key=>$value)
                    <option value="{{ $key }}"@if($key == $selected_group) selected="selected"@endif>{{ $value }}</option>
                @endforeach
            </select>
            <input type="submit" value="Filter" class="postfix button expanded" />
        </form>
    @endif

    <ul class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-8 gap-y-6 mb-12">
        @forelse($profiles as $profile)
            <li class="block">
                <a href="{{ $profile['link'] }}" class="underline hover:no-underline">
                    <div class="block bg-cover bg-center w-full pt-portrait lazy mb-1" data-src="{{ $profile['data']['Picture']['url'] ?? '/_resources/images/no-photo.svg' }}"></div>
                    <span class="font-bold">{{ $profile['data']['First Name'] }} {{ $profile['data']['Last Name'] }}</span>
                </a>
                @if(!empty($profile['data']['Title']))
                    <span class="block text-sm">{{ $profile['data']['Title'] }}</span>
                @endif
            </li>
        @empty
            <li>No profiles found.</li>
        @endforelse
    </ul>
@endsection
