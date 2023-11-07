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
            <input type="submit" value="Filter" class="postfix button" />
        </form>
    @endif

    <ul class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-x-6 md:gap-x-8 gap-y-4 lg:gap-y-6 mb-12">
        @forelse($profiles as $profile)
            <li class="block">
                @include('components.profile')
            </li>
        @empty
            <li>No profiles found.</li>
        @endforelse
    </ul>
@endsection
