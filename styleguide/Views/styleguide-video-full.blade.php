@extends('components.content-area')

@section('content')

    <div class="w-full">
        @if(!empty($video_full))
            @include('components.video-full', ['video_full' => $video_full])
        @endif
    </div>

    <div class="row">
        @include('components.page-title', ['title' => $page['title']])
    </div>
@endsection
