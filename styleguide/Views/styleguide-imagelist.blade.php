@extends('partials.content-area')

@section('content')
    <h1 class="page-title">{{ $page['title'] }}</h1>

    <div class="row">
        <div class="medium-6 columns">
            @if(!empty($imagelist))
                <h2>Image List</h2>

                @include('components.image-list', ['images' => $imagelist, 'class' => 'image-list'])
            @endif
        </div>

        <div class="small-12 medium-6 columns">
            @if(!empty($imagelist))
                <h2>Image List Lazy</h2>

                @include('components.image-list-lazy', ['images' => $imagelist, 'class' => 'rotate'])
            @endif
        </div>
    </div>
@endsection
