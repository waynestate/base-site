@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="row">
        <div class="w-full xl:w-1/2">
            @if(!empty($video))
                @include('components.video', ['video' => $video])
            @endif
        </div>
    </div>
@endsection
