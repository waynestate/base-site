{{--
    $buttons => array // ['option', 'link', 'title', 'relative_url']
    $class => string // 'image-button-list'
--}}
@if(!empty($class))<div class="{{ $class }}">@endif

<ul>
    @foreach($buttons as $button)
        <li class="min-w-full px-4 mt:px-0{{ empty($class) ? ' mb-4' : '' }}">
            @if(!empty($button['option']) && view()->exists('components.button-'.\Illuminate\Support\Str::slug($button['option'])))
                @include('components.button-'.\Illuminate\Support\Str::slug($button['option']), ['button' => $button])
            @else
                @include('components.button-default', ['button' => $button])
            @endif
        </li>
    @endforeach
</ul>

@if(!empty($class))</div>@endif
