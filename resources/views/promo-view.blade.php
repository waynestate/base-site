@extends('components.content-area')

@section('content')
    <div class="row flex flex-wrap -mx-4">
        <div class="w-full md:w-1/3 px-4 mt-6">
            @if(!empty($promo['relative_url']))
                @image($promo['relative_url'], $promo['filename_alt_text'], 'sm:h-64 md:h-auto mx-auto md:mx-0')
            @else
                <img src="/_resources/images/no-photo.svg" alt="{{ $base['page']['title'] }}" class="sm:h-64 md:h-auto block mx-auto md:mx-0">
            @endif
        </div>

        <div class="w-full md:w-2/3 px-4">
            @include('components.page-title', ['title' => $base['page']['title']])

            <div class="content">
                @if(!empty($promo['excerpt']))
                    <p>{{ $promo['excerpt'] }}</p>
                @endif

                @if(!empty($promo['description']))
                    {!! $promo['description'] !!}
                @endif

                @if($back_url != '')
                    <p class="pt-4">
                        <a href="{{ $back_url }}" class="button">&larr; Return to listing</a>
                    </p>
                @endif
            </div>
        </div>
    </div>

    @if(using_styleguide() == true)
        <div class="content">
            {!! $base['page']['content']['main'] !!}
        </div>
    @endif
@endsection
