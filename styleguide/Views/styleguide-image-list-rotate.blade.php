@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="row">
        <div class="w-full sm:w-1/2">
            @if(!empty($images))
                @include('components.image-button-list', ['images' => $images, 'class' => 'rotate'])
            @endif
        </div>
    </div>
@endsection
