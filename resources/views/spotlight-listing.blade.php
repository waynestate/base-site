@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="content">
        {!! $page['content']['main'] !!}
    </div>

    @if(!empty($spotlights))
        <ul class="mt-8">
            @foreach($spotlights as $spotlight)
                <li class="flex mb-8 pb-8 @if(!$loop->last) border-b border-grey-lighter @endif -mx-4">
                    <div class="w-1/5 px-4">
                        <a href="{{ !empty($spotlight['link']) ? $spotlight['link'] : 'spotlights/'.\Illuminate\Support\Str::slug($spotlight['title']).'-'.$spotlight['promo_item_id'] }}" aria-label="View {{ $spotlight['title'] }} spotlight">
                            @if(!empty($spotlight['relative_url']))
                                @image($spotlight['relative_url'], $spotlight['filename_alt_text'], 'w-full')
                            @else
                                <div class="w-full pt-4/3 bg-cover bg-center" style="background-image: url('/_resources/images/no-photo.svg');"></div>
                            @endif
                        </a>
                    </div>
                    <div class="px-4 w-4/5 content">
                        <h2 class="text-normal text-lg mb-2">
                            <a href="{{ !empty($spotlight['link']) ? $spotlight['link'] : 'spotlights/'.\Illuminate\Support\Str::slug($spotlight['title']).'-'.$spotlight['promo_item_id'] }}">{{ $spotlight['title'] }}</a>
                        </h2>

                        @if(!empty($spotlight['excerpt']))
                            <div>{{ $spotlight['excerpt'] }}</div>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    @if(!empty($pages))
        <div class="flex justify-center">
            <a href="?page={{ $pages['prev_page'] }}" class="mx-4 button w-1/2 lg:w-1/5">&larr; &nbsp; Previous</a>
            @if($pages['next_page'] != null || $pages['next_page'] === 0)
                <a href="?page={{ $pages['next_page'] }}" class="mx-4 button w-1/2 lg:w-1/5">Next &nbsp; &rarr;</a>
            @endif
        </div>
    @endif
@endsection
