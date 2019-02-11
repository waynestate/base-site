@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title'], 'class' => $pageTitleClass ?? ''])

    <div class="content">
        {!! $page['content']['main'] !!}
    </div>

    <div class="flex">
        @foreach($grid_item as $item)
            <div class="bg-grey-lighter">
                <a href="{{ $item['link'] }}">
                    <img src="{{ $item['relative_url'] }}" alt="" role="presentation" />
                    <div class="font-bold">{{ $item['title'] }}</div>
                    {!! strip_tags($image['description']) !!}
                </a>
            </div>
        @endforeach
    </div>

@endsection
