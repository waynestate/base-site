@extends('partials.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="row">
        <div class="small-12 medium-6 columns">
            @if(!empty($images))
                @include('components.image-button-list', ['images' => $images, 'class' => 'rotate'])
            @endif
        </div>
    </div>
@endsection
