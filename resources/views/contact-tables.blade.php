@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="content">
        {!! $page['content']['main'] !!}
    </div>

    <a id="directory-contents"></a>

    @if(!empty($groups_left) && !empty($groups_right))
        <h2>Table of contents</h2>
        <div class="flex -mx-4 mb-8 w-full">
            <ul class="mx-4 w-full">
                @foreach($groups_left as $group=>$anchor)
                    <li class="list-none"><a href="#{{$anchor}}" class="underline hover:no-underline" aria-label="{{$group}} contacts">{{$group}}</a></li>
                @endforeach
            </ul>
            <ul class="mx-4 w-full">
                @foreach($groups_right as $group=>$anchor)
                    <li class="list-none"><a href="#{{$anchor}}" class="underline hover:no-underline">{{$group}}</a></li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="content">
        @if(!empty($profiles))
            @foreach($profiles as $group=>$profile_list)
                <h2 id="{{$profile_list['anchor']}}">{{$group}}</h2>
                <table class="table-stack">
                    <thead>
                    <tr>
                        <th class="w-48">Name</th>
                        <th>Title</th>
                        <th class="w-40">Office</th>
                        <th class="w-40">Phone</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($profile_list['people'] as $profile)
                        <tr>
                            <td>@if(isset($profile['data']['Email']))<a href="mailto:{{$profile['data']['Email']}}">@endif{{$profile['data']['First Name']}} {{$profile['data']['Last Name']}}@if(isset($profile['data']['Email']))</a>@endif</td>
                            <td>@if(isset($profile['data']['Title'])){{$profile['data']['Title']}}@endif</td>
                            <td>@if(isset($profile['data']['Office Location'])){{$profile['data']['Office Location']}}@endif</td>
                            <td>@if(isset($profile['data']['Phone'])){{$profile['data']['Phone']}}@endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row column text-right">
                    <a href="#directory-contents">Back to top</a>
                </div>
            @endforeach
        @endif
    </div>
@endsection
