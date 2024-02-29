@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))
    
@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    @if(empty($base['components']['page-content-row']) && empty($base['components']['page-content-column']))
        <div class="content">
            {!! $base['page']['content']['main'] !!}
        </div>
    @endif

    @if(!empty($base['components']))
        <div class="grid grid-cols-1 md:grid-cols-2 items-start gap-y-8 sm:gap-x-4 lg:gap-x-8 mt-8 mb-4">
            @foreach($base['components'] as $componentName => $component)
                @if(!empty($component['data']) && !empty($component['component']['filename']))
                    @if(\View::exists('components/'.$component['component']['filename']))
                        <div class="col-span-2 {{ str_contains($component['component']['filename'], 'column') ? 'md:col-span-1' : 'md:col-span-2' }}">
                            @if(!empty($component['component']['heading']))<h2 class="mt-0" id="{{ Str::slug($component['component']['heading']) }}">{{ $component['component']['heading'] }}</h2>@endif

                            @include('components/'.$component['component']['filename'], ['data' => $component['data'], 'component' => $component['component']])
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    @endif
@endsection
