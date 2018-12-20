@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="row">
        <div class="w-full md:w-1/2">
            @if(!empty($featured_promo))
                @include('components.featured-promo', ['featured_promo' => $featured_promo])
            @endif
        </div>
    </div>
@endsection
