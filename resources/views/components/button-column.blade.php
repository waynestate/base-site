{{--
    $button => array // ['title', 'link']
    $component['buttonSize'] => string // 'large'
--}}

@php
    $sizeClass = !empty($component['buttonSize']) ? ' button--'.$component['buttonSize'] : '';
@endphp

<ul class="grid grid-cols-1 gap-4 gap-y-2 xl:mx-0 items-start">
    @foreach($data as $button)
        <li class="block">
            @if(!empty($button['option']) && $button['option'] === 'Image')
                @include('components.buttons.image', ['button' => $button, 'class' => 'w-full'])
            @elseif(!empty($button['option']) && $button['option'] != 'Default')
                @include('components.buttons.default', ['button' => $button, 'class' => 'w-full '.\Illuminate\Support\Str::slug($button['option']).'-button'.$sizeClass])
            @else
                @include('components.buttons.default', ['button' => $button, 'class' => 'w-full'.$sizeClass])
            @endif
        </li>
    @endforeach
</ul>
