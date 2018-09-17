@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="w-full xl:w-3/4">
        <div class="row flex flex-wrap -mx-4">
            @if(!empty($buttons))
                @foreach($buttons as $button)
                    <div class="w-full sm:w-1/2 px-4">
                        @if(!empty($button[1]['option']))
                            <h2>{{ $button[1]['option'] }}</h2>
                        @else
                            <h2>Default</h2>
                        @endif

                        @include('components.under-menu', ['buttons' => $button])
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
