@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 items-start gap-y-8 sm:gap-x-4 lg:gap-x-8 mt-8 mb-4">
        @if(!empty($components))
            @foreach($components as $componentName => $component)
                @if(!empty($component['data']) && !empty($component['component']['filename']))
                    @include('modular/components/'.$component['component']['filename'], ['data' => $component['data'], 'component' => $component['component']])
                @endif
            @endforeach
        @endif
    </div>
@endsection
