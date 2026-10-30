@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('partials.page-title', ['title' => $base['page']['title']])
    @include('components.page-content')
    
    @php
        $columns = config('base.profile.columns', 4);
        $gridCols = match($columns) {
            2 => 'grid-cols-2',
            3 => 'grid-cols-2 md:grid-cols-3',
            default => 'grid-cols-2 md:grid-cols-3 xl:grid-cols-4',
        };
    @endphp

    @if(!empty($profiles))
        @foreach($profiles as $key => $groups)
            <h2>{{ $key }}</h2>

            @if($columns === 1)
                <ul class="divide-y divide-gray-200 mb-12">
                    @foreach($groups as $profile)
                        <li class="py-6 first:pt-0">
                            @include('components.profile-row', ['headingLevel' => 'h3'])
                        </li>
                    @endforeach
                </ul>
            @else
                <ul class="grid {{ $gridCols }} gap-x-6 md:gap-x-8 gap-y-4 lg:gap-y-6 mb-12">
                    @foreach($groups as $profile)
                        <li class="block">
                            @include('components.profile')
                        </li>
                    @endforeach
                </ul>
            @endif
        @endforeach
    @else
        <p>No profiles found.</p>
    @endif
@endsection
