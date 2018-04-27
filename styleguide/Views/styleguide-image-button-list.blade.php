@extends('partials.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="row">
        <div class="w-full sm:w-1/2">
            @if(!empty($imagebutton))
                @include('components.image-button-list', ['images' => $imagebutton])
            @endif
        </div>
    </div>
@endsection
