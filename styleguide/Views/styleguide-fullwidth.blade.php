@extends('components.content-area')

@section('head')
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@1,300;1,400;1,700&display=swap" rel="stylesheet">
@endsection

@section('hero-buttons')
    @include('components/button-row', ['data' => $button_row_1['data'], 'component' => $button_row_1['component']])
@endsection

@section('content')
    <div class="row px-4">
        @include('components.page-title', ['title' => $base['page']['title']])

        @include('components/icons-row', ['data' => $icons_row_1['data'], 'component' => $icons_row_1['component']])

        <div class="content">
            {!! $base['page']['content']['main'] !!}
        </div>

        <div class="my-10 grid grid-cols-1 md:grid-cols-12 items-start gap-y-8 sm:gap-x-4 lg:gap-x-12 grid-flow-dense">
            @if(!empty($icons_row_2['data']))
                <div class="col-span-full">
                    @if(!empty($icons_row_2['component']['heading']))<h2 class="mt-0">{{ $icons_row_2['component']['heading'] }}</h2>@endif
                    @include('components/'.$icons_row_2['component']['filename'], ['data' => $icons_row_2['data'], 'component' => $icons_row_2['component']])
                </div>
            @endif

            @if(!empty($promo_row_2['data']))
                <div class="col-span-full">
                    @if(!empty($promo_row_2['component']['heading']))<h2 class="mt-0">{{ $promo_row_2['component']['heading'] }}</h2>@endif
                    @include('components/'.$promo_row_2['component']['filename'], ['data' => $promo_row_2['data'], 'component' => $promo_row_2['component']])
                </div>
            @endif
        </div>
    </div>

    @if(!empty($promo_column_3['data']))
        <div class="bg-gray-100 my-10 py-10">
            <div class="row px-4">
                @if(!empty($promo_column_3['component']['heading']))<h2 class="mt-0">{{ $promo_column_3['component']['heading'] }}</h2>@endif
                @include('components/'.$promo_column_3['component']['filename'], ['data' => $promo_column_3['data'], 'component' => $promo_column_3['component']])
            </div>
        </div>
    @endif

    <div class="row px-4 my-10 py-4">
        @if(!empty($promo_column_1['data']) || !empty($events_column['data']))<h2 class="mt-0">{{ $events_column['component']['heading'] ?? "Events" }}</h2>@endif
        <div class="grid grid-cols-1 md:grid-cols-12 items-start gap-y-8 sm:gap-x-4 lg:gap-x-12 grid-flow-dense">
            @if(!empty($promo_column_1['data']))
                <div class="col-span-full md:col-span-6 xl:col-span-4">
                    @include('components/'.$promo_column_1['component']['filename'], ['data' => $promo_column_1['data'], 'component' => $promo_column_1['component']])
                </div>
            @endif

            @if(!empty($events_column['data']))
                <div class="col-span-full lg:col-span-6 xl:col-span-8">
                    @include('components/'.$events_column['component']['filename'], ['data' => $events_column['data'], 'component' => $events_column['component']])
                    <div class="text-right">
                        <a href="#" class="button mt-4">More events</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if(!empty($news_row['data']))
        <div class="bg-gray-100 py-10 my-10">
            <div class="row px-4">
                <h2 class="mt-0">{{ $news_row['component']['heading'] ?? "News" }}</h2>
                @include('components/'.$news_row['component']['filename'], ['data' => $news_row['data'], 'component' => $news_row['component']])
            </div>
        </div>
    @endif

    @if(!empty($promo_row_1['data']))
        <div class="row px-4 my-10">
            @if(!empty($promo_row_1['component']['heading']))<h2 class="mt-0">{{ $promo_row_1['component']['heading'] }}</h2>@endif
            @include('components/'.$promo_row_1['component']['filename'], ['data' => $promo_row_1['data'], 'component' => $promo_row_1['component']])
        </div>
    @endif

    @if(!empty($spotlight_column['data']))
        <div class="bg-gray-100 py-10 my-10 -mb-8">
            <div class="row px-4">
                <h2 class="mt-0">{{ $spotlight_column['component']['heading'] ?? "Spotlights" }}</h2>
                <div class="grid lg:grid-cols-2 gap-6 xl:gap-14">
                    @include('components/'.$spotlight_column['component']['filename'], ['data' => $spotlight_column['data'], 'component' => $spotlight_column['component']])
                </div>
            </div>
        </div>
    @endif


@endsection
