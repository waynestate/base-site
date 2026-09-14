@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('partials.page-title', ['title' => $base['page']['title']])
    @include('components.page-content')

    <a id="directory-contents"></a>

    @if(!empty($anchors))
        <h2>Table of contents</h2>
        <div class="mb-8">
            <ul class="table-of-contents">
                @foreach($anchors as $group=>$anchor)
                    <li class="list-none"><a href="#{{$anchor}}" class="underline hover:no-underline">{{$group}}</a></li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="content">
        @if(!empty($profiles))
            @php
                $tableFields = config('base.profile.table_fields', ['Title', 'Office', 'Phone']);
                $linkToProfile = config('base.profile.singleProfileView') === true || config('base.profile.table_name_link') === 'profile';
            @endphp
            @foreach($profiles as $group=>$profile_list)
                <h2 @if(!empty($anchors)) id="{{$anchors[$group]}}" @endif>{{$group}}</h2>
                <table class="table-stack md:table-fixed w-full">
                    <thead>
                    <tr>
                        <th class="w-48">Name</th>
                        @foreach($tableFields as $field)
                            <th{!! !$loop->first ? ' class="w-40"' : '' !!}>{{ $field }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($profile_list as $profile)
                        <tr>
                            <td>
                                @if($linkToProfile && !empty($profile['link']))
                                    <a href="{{ $profile['link'] }}">{{ $profile['full_name'] }}</a>
                                @elseif(config('base.profile.table_name_link') !== 'none' && !empty($profile['data']['Email']))
                                    <a href="mailto:{{ $profile['data']['Email'] }}">{{ $profile['full_name'] }}</a>
                                @else
                                    {{ $profile['full_name'] }}
                                @endif
                            </td>
                            @foreach($tableFields as $field)
                                <td>
                                    @if(!empty($profile['data'][$field]))
                                        @include('components.profile-field', ['field' => $field, 'data' => $profile['data'][$field]])
                                    @endif
                                </td>
                            @endforeach
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
