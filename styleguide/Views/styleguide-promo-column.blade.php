@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <p>This component will display a single promotion item in a column at one time. Can be random on refresh. Image is full width on small views.</p>
    </div>


    @if(!empty($accordion))
        @include('components.accordion', ['data' => $accordion])
    @endif

    <h2>Promo column</h2>
    <div class="w-full md:w-1/2">
        @if(!empty($promo_column_1))
            @include('components.promo-column', ['data' => $promo_column_1])
        @endif
    </div>
    <hr />

    <h2>Promo column with youtube link</h2>
    <div class="w-full md:w-1/2">
        @if(!empty($promo_column_2))
            @include('components.promo-column', ['data' => $promo_column_2])
        @endif
    </div>
@endsection
