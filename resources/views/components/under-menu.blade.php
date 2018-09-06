{{--
    $buttons => array // [['link', 'title', 'relative_url']]
    $class => string // 'image-button-list'
--}}
@if(!empty($class))<div class="{{ $class }}">@endif

@foreach($buttons as $button)
    <div class="min-w-full px-4 mt:px-0{{ empty($class) ? ' mb-4' : '' }}">
        @if(empty($button['option']))
            @include('components.button-default', ['button' => $button])
        @endif

        @if(!empty($button['option']) && $button['option'] === 'Bg gradient green')
            @include('components.button-bg-gradient-green', ['button' => $button])
        @endif

        @if(!empty($button['option']) && $button['option'] === 'Bg image dark')
            @include('components.button-bg-image-dark', ['button' => $button])
        @endif

        @if(!empty($button['option']) && $button['option'] === 'Bg image light')
            @include('components.button-bg-image-light', ['button' => $button])
        @endif

        @if(!empty($button['option']) && $button['option'] === 'Icon dark')
            @include('components.button-icon-dark', ['button' => $button])
        @endif

        @if(!empty($button['option']) && $button['option'] === 'Icon light')
            @include('components.button-icon-light', ['button' => $button])
        @endif

        @if(!empty($button['option']) && $button['option'] === 'Icon dark w/ img bg')
            @include('components.button-icon-dark-w-img-bg', ['button' => $button])
        @endif

        @if(!empty($button['option']) && $button['option'] === 'Icon light w/ img bg')
            @include('components.button-icon-light-w-img-bg', ['button' => $button])
        @endif

        @if(!empty($button['option']) && $button['option'] === 'SVG overlay dark')
            @include('components.button-svg-overlay-dark', ['button' => $button])
        @endif

        @if(!empty($button['option']) && $button['option'] === 'SVG overlay light')
            @include('components.button-svg-overlay-light', ['button' => $button])
        @endif
    </div>
@endforeach

@if(!empty($class))</div>@endif
