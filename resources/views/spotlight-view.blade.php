@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="content">
        {!! $page['content']['main'] !!}
    </div>

    @if(!empty($spotlights))
        <ul>
            @foreach($spotlights as $item)
                <li>{{ $item['title'] }}</li>
            @endforeach
        </ul>
    @endif
@endsection
