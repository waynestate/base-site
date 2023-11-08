@extends('layouts.' . (!empty($layout) ? $layout : 'main'))

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <p>You can have up to four columns in your contact footer.</p>
        <ul class="-mt-2">
            <li><a href="/styleguide/footer/contact/one">One column</a></li>
            <li><a href="/styleguide/footer/contact/two">Two columns</a></li>
            <li><a href="/styleguide/footer/contact/three">Three columns</a></li>
            <li><a href="/styleguide/footer/contact/four">Four columns</a></li>
        </ul>
    </div>
@endsection
