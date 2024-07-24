@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))
    
@section('content')
    @include('components.page-title', ['title' => $base['page']['title'], 'class' => in_array($base['page']['controller'], config('base.full_width_controllers')) ? 'row px-4' : '' ])

    @if(empty($base['components']['page-content-row']) && empty($base['components']['page-content-column']))
        <div class="content">
            {!! $base['page']['content']['main'] !!}
        </div>
    @endif

    @include('partials.component-loop')
@endsection
