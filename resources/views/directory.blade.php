@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('components.page-content')
    
    @if(!empty($profiles))
        @foreach($profiles as $key => $groups)
            <h2>{{ $key }}</h2>

            <ul class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-x-6 md:gap-x-8 gap-y-4 lg:gap-y-6 mb-12">
                @foreach($groups as $profile)
                    <li class="block">
                        @include('components.profile')
                    </li>
                @endforeach
            </ul>
        @endforeach
    @else
        <p>No profiles found.</p>
    @endif
@endsection
