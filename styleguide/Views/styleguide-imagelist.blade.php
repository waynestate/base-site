@extends('partials.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="row">
        <div class="medium-6 columns">
            @if(!empty($imagebutton))
                <h2>Image/Button List</h2>

                @include('components.image-button-list', ['images' => $images])
            @endif
        </div>
    </div>
@endsection
