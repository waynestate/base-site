@extends('partials.content-area')

@section('content')
    <h1 class="page-title">{{ $page['title'] }}</h1>

    <div class="row">
        <div class="medium-6 columns">
            @if(!empty($imagebutton))
                <h2>Image/Button List</h2>

                @include('components.image-button-list', ['images' => $imagebutton, 'class' => 'image-list'])
            @endif
        </div>

        <div class="small-12 medium-6 columns">
            @if(!empty($images))
                <h2>Image List Lazy Loaded</h2>

                @include('components.image-list-lazy', ['images' => $images, 'class' => 'rotate'])
            @endif
        </div>
    </div>
@endsection
