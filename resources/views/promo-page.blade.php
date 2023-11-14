@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content mb-10">
        {!! $base['page']['content']['main'] !!}
    </div>

    <section>
        @if(!empty($template['group_by_options']) && $template['group_by_options'] === true)
            @foreach($promos as $group => $group_items)
                @if(!empty($group))
                    <h2 class="border-solid border-b-2 pb-1 border-gold my-4">{{ $group }}</h2>
                @else
                    <hr class="border-gold border-b-2 my-4" />
                @endif
                @if(!empty($template['columns']))
                    <div class="md:grid grid-cols-2 xl:grid-cols-3 2xl:grid-cols-{{ $template['columns'] }} gap-6">
                        @foreach($group_items as $item)
                            @include('components.promo-grid-item')
                        @endforeach
                    </div>
                @else
                    @foreach($group_items as $item)
                        @include('components.promo-list-item')
                    @endforeach
                @endif
            @endforeach
        @else
            @if(!empty($template['columns']))
                <div class="md:grid grid-cols-2 xl:grid-cols-3 2xl:grid-cols-{{ $template['columns'] }} gap-6">
                    @foreach($promos as $item)
                        @include('components.promo-grid-item')
                    @endforeach
                </div>
            @else
                @foreach($promos as $item)
                    @include('components.promo-list-item')
                @endforeach
            @endif
        @endif
    </section>

    @if(!empty($pages))
        <div class="flex justify-center">
            <a href="?page={{ $pages['prev_page'] }}" class="mx-4 button w-1/2 lg:w-1/5">&larr; &nbsp; Previous</a>
            @if($pages['next_page'] != null || $pages['next_page'] === 0)
                <a href="?page={{ $pages['next_page'] }}" class="mx-4 button w-1/2 lg:w-1/5">Next &nbsp; &rarr;</a>
            @endif
        </div>
    @endif
@endsection
