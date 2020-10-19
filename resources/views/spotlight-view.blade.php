@extends('components.content-area')

@section('content')
    <div class="row flex flex-wrap -mx-4">
        <div class="w-full lg:w-1/3 px-4 mt-6 mb-4">
            @if(!empty($spotlight['relative_url']))
                @image($spotlight['relative_url'], $spotlight['filename_alt_text'], 'w-full')
            @else
                <div class="w-full pt-4/3 bg-cover bg-center" style="background-image: url('/_resources/images/no-photo.svg');"></div>
            @endif
        </div>

        <div class="w-full lg:w-2/3 px-4">
            @include('components.page-title', ['title' => $page['title'], 'class' => 'hidden lg:block'])

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
