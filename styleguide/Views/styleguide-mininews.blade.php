@extends('partials.content-area')

@section('content')
    <h1 class="page-title">{{ $page['title'] }}</h1>

    <div class="row">
        <div class="small-12 large-6 columns">
            @if(isset($news))
                @include('components.mini-news', ['news' => $news, 'url' => $site['subsite-folder'].'news'])
            @endif
        </div>
    </div>
@endsection
