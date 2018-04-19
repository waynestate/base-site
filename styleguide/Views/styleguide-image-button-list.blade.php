@extends('partials.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="row">
        <div class="medium-6 columns">
            @if(!empty($imagebutton))
                @include('components.image-button-list', ['images' => $imagebutton])
            @endif
        </div>
    </div>
@endsection
