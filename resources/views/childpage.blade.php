@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))
    
@section('content')
    @include('components.page-content')
@endsection
