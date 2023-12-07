@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>

    @if(!empty($components))
        <div class="grid grid-cols-1 md:grid-cols-2 items-start gap-y-8 sm:gap-x-4 lg:gap-x-8 mt-8 mb-4">
            @foreach($components as $componentName => $component)
                @if(!empty($component['data']) && !empty($component['component']['filename']))
                    <div class="col-span-2 {{ str_contains($component['component']['filename'], 'column') ? 'md:col-span-1' : 'md:col-span-2' }}">
                        @if(!empty($component['component']['heading']))<h2 class="mt-0">{{ $component['component']['heading'] }}</h2>@endif

                        @include('components/'.$component['component']['filename'], ['data' => $component['data'], 'component' => $component['component']])
                    </div>
                @endif
            @endforeach
        </div>
    @endif
@endsection
