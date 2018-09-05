{{--
    $images => array // [['link', 'title', 'relative_url']]
    $class => string // 'image-button-list'
--}}
@if(!empty($class))<div class="{{ $class }}">@endif

@foreach($images as $image)
    <div class="min-w-full{{ empty($class) ? ' my-4' : '' }}">
        @if(empty($image['option']))
            @include('components.button-default', ['button' => $image])
        @endif

        @if(!empty($image['option']) && $image['option'] === 'Bg gradient green')
            @include('components.button-bg-gradient-green', ['button' => $image])
        @endif

        @if(!empty($image['option']) && $image['option'] === 'Bg image dark')
            @include('components.button-bg-image-dark', ['button' => $image])
        @endif

        @if(!empty($image['option']) && $image['option'] === 'Bg image light')
            @include('components.button-bg-image-light', ['button' => $image])
        @endif

        @if(!empty($image['option']) && $image['option'] === 'Icon dark')
            @include('components.button-icon-dark', ['button' => $image])
        @endif

        @if(!empty($image['option']) && $image['option'] === 'Icon light')
            @include('components.button-icon-light', ['button' => $image])
        @endif

        @if(!empty($image['option']) && $image['option'] === 'Icon dark w/ img bg')
            @include('components.button-icon-dark-w-img-bg', ['button' => $image])
        @endif

        @if(!empty($image['option']) && $image['option'] === 'Icon light w/ img bg')
            @include('components.button-icon-light-w-img-bg', ['button' => $image])
        @endif

        @if(!empty($image['option']) && $image['option'] === 'SVG overlay dark')
            @include('components.button-svg-overlay-dark', ['button' => $image])
        @endif

        @if(!empty($image['option']) && $image['option'] === 'SVG overlay light')
            @include('components.button-svg-overlay-light', ['button' => $image])
        @endif
    </div>
@endforeach

@if(!empty($class))</div>@endif
