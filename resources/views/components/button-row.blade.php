{{--
    $button => array // ['title', 'link']
    $component['buttonSize'] => string // 'large'
--}}

@php
    $sizeClass = !empty($component['buttonSize']) ? ' button--'.$component['buttonSize'] : '';
    $colCountMd = !empty($component['columns']) && count($data) > 1 ? count($data) % 2 == 0 ? '2' : '3' : '';
    $colCountXl = !empty($component['columns']) ? $component['columns'] : '3';
@endphp

<ul class="grid md:grid-cols-{{ $colCountMd }} xl:grid-cols-{{ $colCountXl }} xl:mx-0 items-start gap-x-4 gap-y-2">
    @foreach($data as $button)
        @php
            $widthClass = !empty($component['columns']) && $component['columns'] === 1 ? '' : 'w-full';
        @endphp

        <li class="block text-center">
            @if(!empty($button['option']) && $button['option'] === 'Image')
                @include('components.buttons.image', ['button' => $button, 'class' => $widthClass.' text-lg'])
            @elseif(!empty($button['option']) && $button['option'] != 'Default')
                @include('components.buttons.default', ['button' => $button, 'class' => $widthClass.' text-lg '.\Illuminate\Support\Str::slug($button['option']).'-button'.$sizeClass])
            @else
                @include('components.buttons.default', ['button' => $button, 'class' => $widthClass.' text-lg'.$sizeClass])
            @endif
        </li>
    @endforeach
</ul>
