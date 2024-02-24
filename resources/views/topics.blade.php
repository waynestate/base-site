@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>

    @if(!empty($topics['data']))
        @foreach($topics['data'] as $letter => $topics)
            <div class="mb-6">
                <h2 class="gold-line">{{ strtoupper($letter) }}</h2>
                <div class="flex flex-wrap">
                    @foreach($topics as $topic)
                        <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 mb-6"><a href="{{ $topic['url'] }}">{{ $topic['name'] }}</a></div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
@endsection
