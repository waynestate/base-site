@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))
    
@section('content')
    @if(empty($base['components']['page-content-row']) && empty($base['components']['page-content-column']))
        @include('components.page-content')
    @endif
@endsection
