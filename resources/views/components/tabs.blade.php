@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('partials.page-title', ['title' => $base['page']['title']])
    @include('components.page-content')

    @if(!empty($tabsitems))
        <ul class="list-disc">
            @foreach($tabsitems as $item)
                <li>{{ $item['title'] }}</li>
            @endforeach
        </ul>
    @endif
@endsection
