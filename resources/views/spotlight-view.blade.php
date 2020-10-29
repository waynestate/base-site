@extends('components.content-area')

@section('content')
    <div class="row flex flex-wrap -mx-4">
        <div class="w-full md:w-1/3 px-4 mt-6">
            @if(!empty($spotlight['relative_url']))
                @image($spotlight['relative_url'], $spotlight['filename_alt_text'], 'sm:h-64 md:h-auto mx-auto md:mx-0')
            @else
                <img src="/_resources/images/no-photo.svg" alt="{{ $page['title'] }}" class="sm:h-64 md:h-auto block mx-auto md:mx-0">
            @endif
        </div>

        <div class="w-full md:w-2/3 px-4">
            @include('components.page-title', ['title' => $page['title']])

            <div class="content">
                @if(!empty($spotlight['excerpt']))
                    <p>{{ $spotlight['excerpt'] }}</p>
                @endif

                @if(!empty($spotlight['description']))
                    {!! $spotlight['description'] !!}
                @endif

                @if($back_url != '')
                    <p class="pt-4">
                        <a href="{{ $back_url }}" class="button">&larr; Return to listing</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
