@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('partials.page-title', ['title' => $base['page']['title']])
    @include('components.page-content')

    @if($hide_filtering == false)
        <form name="departments" method="get" class="filter formy mb-6">
            <label for="filter-group" class="text-black block mb-2">View by department:</label>
            <select name="group" id="filter-group">
                @foreach($dropdown_groups as $key=>$value)
                    <option value="{{ $key }}"@if($key == $selected_group) selected="selected"@endif>{{ $value }}</option>
                @endforeach
            </select>
            <input type="submit" value="Filter" class="postfix button" />
        </form>
    @endif

    @php
        $columns = config('base.profile.columns', 4);
        $gridCols = match($columns) {
            2 => 'grid-cols-2',
            3 => 'grid-cols-2 md:grid-cols-3',
            default => 'grid-cols-2 md:grid-cols-3 xl:grid-cols-4',
        };
    @endphp

    @if($columns === 1)
        <ul class="divide-y divide-gray-200 mb-12">
            @forelse($profiles as $profile)
                <li class="py-6 first:pt-0">
                    @include('components.profile-row', ['headingLevel' => 'h2'])
                </li>
            @empty
                <li>No profiles found.</li>
            @endforelse
        </ul>
    @else
        <ul class="grid {{ $gridCols }} gap-x-6 md:gap-x-8 gap-y-4 lg:gap-y-6 mb-12">
            @forelse($profiles as $profile)
                <li class="block">
                    @include('components.profile')
                </li>
            @empty
                <li>No profiles found.</li>
            @endforelse
        </ul>
    @endif
@endsection
