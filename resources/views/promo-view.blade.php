@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @if(using_styleguide() == true)
        @include('components.page-content')
    @endif

    <div class="w-full md:w-1/2 lg:w-1/3 mt-6 my-4 md:ml-4 float-right">
        @if(!empty($promo['relative_url']))
            @image($promo['relative_url'], $promo['filename_alt_text'], 'mx-auto md:mx-0')
        @else
            <img src="/_resources/images/no-photo.svg" alt="{{ $base['page']['title'] }}" class="sm:h-64 md:h-auto block mx-auto md:mx-0">
        @endif
    </div>

    <div class="content pt-1">
        @include('partials.page-title', ['title' => $base['page']['title']])

        @if(!empty($promo['excerpt']))
            <p>{!! strip_tags($promo['excerpt'], ['em', 'strong', 'br', '&ldquo;', '&rdquo;']) !!}</p>
        @endif

        @if(!empty($promo['description']))
            {!! $promo['description'] !!}
        @endif
    </div>

    <div>
        @if($back_url != '')
            <p class="pt-4">
                <a href="{{ $back_url }}" class="button">&larr; Return to listing</a>
            </p>
        @endif
    </div>
@endsection
