{{--
    $images => array // [['link', 'title', 'relative_url']]
    $class => string // 'image-button-list'
--}}
@if(!empty($class))<div class="{{ $class }}">@endif

@foreach($images as $image)
    <div class="min-w-full{{ empty($class) ? ' my-4' : '' }}">
        @if(empty($image['option']))
            @if(!empty($image['excerpt']))
                <a href="{{ $image['link'] }}" class="button expanded text-left">
                    <div class="block text-xl leading-tight">{{ $image['title'] }}</div>
                    <div class="block pb-1 leading-tight">{{ $image['excerpt'] }}</div>
                </a>
            @else
                <a href="{{ $image['link'] }}" class="button expanded">{{ $image['title'] }}</a>
            @endif
        @endif

        @if(!empty($image['option']) && $image['option'] === 'Bg gradient green')
            @if(!empty($image['excerpt']))
                <a href="{{ $image['link'] }}" class="button expanded bg-gradient-green text-white text-left">
                    <div class="block text-xl leading-tight">{{ $image['title'] }}</div>
                    <div class="block pb-1 leading-tight">{{ $image['excerpt'] }}</div>
                </a>
            @else
                <a href="{{ $image['link'] }}" class="button expanded bg-gradient-green text-white">{{ $image['title'] }}</a>
            @endif
        @endif

        @if(!empty($image['option']) && $image['option'] === 'Bg image dark')
            <a href="{{ $image['link'] }}" class="block min-w-full relative rounded bg-cover bg-green-darkest" style="padding-top: 36.39%; background-image: url('{{ $image['relative_url'] }}'); ">
                <div class="absolute pin p-4 rounded bg-green-darkest opacity-65"></div>
                <div class="absolute pin p-4 flex @if(!empty($image['excerpt'])) justify-start flex-col @else items-center @endif">
                    <div class="min-w-full text-xl font-bold text-white leading-tight @if(empty($image['excerpt'])) text-center @endif">{{ $image['title'] }}</div>
                    @if(!empty($image['excerpt']))
                        <div class="min-w-full text-white leading-tight">{{ $image['excerpt'] }}</div>
                    @endif
                </div>
            </a>
        @endif

        @if(!empty($image['option']) && $image['option'] === 'Bg image light')
            <a href="{{ $image['link'] }}" class="block min-w-full relative rounded bg-grey-lighter bg-cover" style="padding-top: 36.39%; background-image: url('{{ $image['relative_url'] }}'); ">
                <div class="absolute pin p-4 rounded bg-grey-lighter opacity-65"></div>
                <div class="absolute pin p-4 flex @if(!empty($image['excerpt'])) justify-start flex-col @else items-center @endif">
                    <div class="min-w-full text-xl font-bold text-black leading-tight @if(empty($image['excerpt'])) text-center @endif">{{ $image['title'] }}</div>
                    @if(!empty($image['excerpt']))
                        <div class="min-w-full text-black leading-tight">{{ $image['excerpt'] }}</div>
                    @endif
                </div>
            </a>
        @endif

        @if(!empty($image['option']) && $image['option'] === 'Icon dark')
            <a href="{{ $image['link'] }}" class="block min-w-full relative rounded bg-gradient-green hover:bg-gradient-green" style="padding-top: 36.39%;">
                <div class="absolute min-w-full flex pin content-start items-center p-4">
                    <div class="w-1/4">
                    <!-- TODO: DELETE // Dealing with styleguide secondary image -->@if(!empty($promo_group_id)) <img src="/promos/{{ $image['promo_group_id'] }}/{{ $image['secondary_image']}}"> @else <img src="{{ $image['secondary_image']}}"> @endif
                    </div>
                    <div class="w-3/4 pl-4">
                        <div class="block text-xl font-bold text-white leading-tight">{{ $image['title'] }}</div>
                        @if(!empty($image['excerpt']))
                            <div class="block text-white leading-tight">{{ $image['excerpt'] }}</div>
                        @endif
                    </div>
                </div>
            </a>
        @endif

        @if(!empty($image['option']) && $image['option'] === 'Icon light')
            <a href="{{ $image['link'] }}" class="block min-w-full relative rounded bg-grey-lighter hover:bg-grey-lightest" style="padding-top: 36.39%;">
                <div class="absolute min-w-full flex pin content-start items-center p-4">
                    <div class="w-1/4">
                    <!-- TODO: DELETE // Dealing with styleguide secondary image -->@if(!empty($promo_group_id)) <img src="/promos/{{ $image['promo_group_id'] }}/{{ $image['secondary_image']}}"> @else <img src="{{ $image['secondary_image']}}"> @endif
                    </div>
                    <div class="w-3/4 pl-4">
                        <div class="block text-xl font-bold text-black leading-tight">{{ $image['title'] }}</div>
                        @if(!empty($image['excerpt']))
                            <div class="leading-tight text-black">{{ $image['excerpt'] }}</div>
                        @endif
                    </div>
                </div>
            </a>
        @endif

        @if(!empty($image['option']) && $image['option'] === 'Icon dark w/ img bg')
            <a href="{{ $image['link'] }}" class="block min-w-full relative rounded bg-gradient-green bg-cover" style="padding-top: 36.39%; background-image: url('{{ $image['relative_url'] }}'); ">
                <div class="absolute pin p-4 rounded bg-green-darkest opacity-65"></div>
                <div class="absolute min-w-full flex pin content-start items-center p-4">
                    <div class="w-1/4">
                    <!-- TODO: DELETE // Dealing with styleguide secondary image -->@if(!empty($promo_group_id)) <img src="/promos/{{ $image['promo_group_id'] }}/{{ $image['secondary_image']}}"> @else <img src="{{ $image['secondary_image']}}"> @endif
                    </div>
                    <div class="w-3/4 pl-4">
                        <div class="block text-xl font-bold text-white leading-tight">{{ $image['title'] }}</div>
                        @if(!empty($image['excerpt']))
                            <div class="block text-white leading-tight">{{ $image['excerpt'] }}</div>
                        @endif
                    </div>
                </div>
            </a>
        @endif

        @if(!empty($image['option']) && $image['option'] === 'Icon light w/ img bg')
            <a href="{{ $image['link'] }}" class="block min-w-full relative rounded bg-grey-lighter bg-cover" style="padding-top: 36.39%; background-image: url('{{ $image['relative_url'] }}'); ">
                <div class="absolute pin p-4 rounded bg-grey-lighter opacity-65"></div>
                <div class="absolute min-w-full flex pin content-start items-center p-4">
                    <div class="w-1/4">
                    <!-- TODO: DELETE // Dealing with styleguide secondary image -->@if(!empty($promo_group_id)) <img src="/promos/{{ $image['promo_group_id'] }}/{{ $image['secondary_image']}}"> @else <img src="{{ $image['secondary_image']}}"> @endif
                    </div>
                    <div class="w-3/4 pl-4">
                        <div class="block text-xl font-bold text-black leading-tight">{{ $image['title'] }}</div>
                        @if(!empty($image['excerpt']))
                            <div class="block text-black leading-tight">{{ $image['excerpt'] }}</div>
                        @endif
                    </div>
                </div>
            </a>
        @endif

        @if(!empty($image['option']) && $image['option'] === 'SVG overlay dark')
            <a href="{{ $image['link'] }}" class="block min-w-full relative rounded bg-cover bg-green-darkest" style="padding-top: 36.39%; background-image: url('{{ $image['relative_url'] }}'); ">
                <div class="absolute pin p-4 rounded bg-green-darkest opacity-65"></div>
                <div class="absolute min-w-full pin rounded">
                    <!-- TODO: DELETE // Dealing with styleguide secondary image -->@if(!empty($promo_group_id)) <img src="/promos/{{ $image['promo_group_id'] }}/{{ $image['secondary_image']}}"> @else <img src="{{ $image['secondary_image']}}"> @endif
                </div>
            </a>
        @endif

        @if(!empty($image['option']) && $image['option'] === 'SVG overlay light')
            <a href="{{ $image['link'] }}" class="block min-w-full relative rounded bg-cover bg-grey-lighter" style="padding-top: 36.39%; background-image: url('{{ $image['relative_url'] }}'); ">
                <div class="absolute pin p-4 rounded bg-grey-lighter opacity-65"></div>
                <div class="absolute min-w-full pin rounded">
                    <!-- TODO: DELETE // Dealing with styleguide secondary image -->@if(!empty($promo_group_id)) <img src="/promos/{{ $image['promo_group_id'] }}/{{ $image['secondary_image']}}"> @else <img src="{{ $image['secondary_image']}}"> @endif
                </div>
            </a>
        @endif
    </div>
@endforeach

@if(!empty($class))</div>@endif
