@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="content">
        {!! $page['content']['main'] !!}
    </div>

    @if(!empty($spotlights))
        <ul class="flex flex-wrap -mx-4">
            @foreach($spotlights as $spotlight)
                <li class="w-1/2 md:w-1/3 xxl:w-1/4 px-4 pb-6">
                    <a href="{{ !empty($spotlight['link']) ? $spotlight['link'] : 'spotlight/'.\Illuminate\Support\Str::slug($spotlight['title']).'-'.$spotlight['promo_item_id'] }}" aria-label="View {{ $spotlight['title'] }} spotlight" class="group block">
                        <div class="w-full">
                            @if(!empty($spotlight['relative_url']))
                                @image($spotlight['relative_url'], $spotlight['filename_alt_text'], 'w-full')
                            @else
                                <div class="w-full pt-portrait bg-cover bg-center" style="background-image: url('/_resources/images/no-photo.svg');"></div>
                            @endif
                        </div>
                        <div class="w-full p-0">
                            <div class="font-bold mt-1 lg:mt-2 underline group-hover:no-underline">{{ $spotlight['title'] }}</div>
                            <p class="text-sm text-black">{{ $spotlight['excerpt'] }}</p>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

@endsection
