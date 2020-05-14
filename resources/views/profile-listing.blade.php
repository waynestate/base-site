@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    @if($hide_filtering == false)
        <form name="departments" method="get" class="filter formy">
            <label for="filter-group" class="text-black block mb-2">View by department:</label>
            <div class="row -mx-4">
                <div class="w-5/6 px-4 inline-block relative w-64 mb-6 flex items-center text-black">
                    <svg class="fill-current h-4 w-4 absolute mr-4 right-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    <select name="group" id="filter-group">
                        @foreach($dropdown_groups as $key=>$value)
                            <option value="{{ $key }}"@if($key == $selected_group) selected="selected"@endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-1/6 px-4">
                    <input type="submit" value="Filter" class="postfix button expanded" />
                </div>
            </div>
        </form>
    @endif

    <ul class="row flex flex-wrap -mx-4">
        @forelse($profiles as $profile)
            <li class="w-full sm:w-1/2 md:w-1/3 xl:w-1/4 px-4 pb-6">
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
