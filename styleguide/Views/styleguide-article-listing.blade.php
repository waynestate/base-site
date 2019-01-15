@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="row">
        <div class="w-full md:w-1/2">
            @if(!empty($articles['data']))
                @include('components.article-listing', ['articles' => $articles['data'], 'url' => $site['subsite-folder'].'news'])
            @endif
        </div>
    </div>
@endsection
