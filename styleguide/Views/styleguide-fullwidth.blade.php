@extends('components.content-area')

@section('head')
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital@1&display=swap" rel="stylesheet">
@endsection

@section('content')
    <div class="row px-4">
        @include('components.page-title', ['title' => $base['page']['title']])
        
        <div class="content">
            {!! $base['page']['content']['main'] !!}

            <blockquote class="italic">
                <p>&ldquo;{{ $faker->paragraph(6) }}&rdquo;</p>
                <cite>&mdash; {{ $faker->name }}</cite>
            </blockquote>
        </div>
    </div>

    @if(!empty($promo_column_3['data']))
        <div class="bg-gray-100 my-8 py-8">
            <div class="row px-4">
                <h2 class="mt-0">{{ $promo_column_3['component']['heading'] }}</h2>
                @include('components/catalog', ['data' => $promo_column_3['data'], 'component' => $promo_column_3['component']])
            </div>
        </div>
    @endif

    <div class="row px-4 my-8">
        <h2 class="mt-0">Events</h2>
        <div class="grid grid-cols-1 md:grid-cols-12 items-start gap-y-8 sm:gap-x-4 lg:gap-x-12 grid-flow-dense">
            @if(!empty($promo_column_1['data']))
                <div class="col-span-full md:col-span-6 xl:col-span-4">
                    @include('components/promo-column', ['data' => $promo_column_1['data'], 'component' => $promo_column_1['component']])
                </div>
            @endif

            @if(!empty($events_column['data']))
                <div class="col-span-full lg:col-span-6 xl:col-span-8">
                    @include('components/events-column', ['data' => $events_column['data'], 'component' => $events_column['component']])
                </div>
            @endif
        </div>
    </div>

    @if(!empty($news_row['data']))
        <div class="bg-gray-100 py-8 my-8">
            <div class="row px-4">
                <h2 class="mt-0">News</h2>
                @include('components/news-row', ['data' => $news_row['data'], 'component' => $news_row['component']])
            </div>
        </div>
    @endif

    @if(!empty($spotlight['data']))
        <div class="row px-4">
            <h2 class="mt-0">Spotlights</h2>
            <div class="grid lg:grid-cols-2 gap-6 xl:gap-14">
                @include('components/spotlight-column', ['data' => $spotlight['data'], 'component' => $spotlight['component']])
            </div>
        </div>
    @endif

@endsection
