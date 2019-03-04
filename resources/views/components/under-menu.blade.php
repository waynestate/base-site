{{--
    $buttons => array // [['link', 'title', 'relative_url']]
    $class => string // 'image-button-list'
--}}
@if(!empty($class))<div class="{{ $class }}">@endif

@foreach($buttons as $button)
    <div class="min-w-full px-4 mt:px-0{{ empty($class) ? ' mb-4' : '' }}">
        @if(!empty($button['option']) && view()->exists('components.button-'.\Illuminate\Support\Str::slug($button['option'])))
            @include('components.button-'.\Illuminate\Support\Str::slug($button['option']), ['button' => $button])
        @else
            @include('components.button-default', ['button' => $button])
        @endif
    </div>
@endforeach

@if(!empty($class))</div>@endif
