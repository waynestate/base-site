{{--
    $button => array // ['title', 'link']
--}}

<ul class="grid md:grid-cols-{{ !empty($component['columns']) && count($data) > 1 ? count($data) % 2 == 0 ? '2' : '3' : '' }} mt:grid-cols-{{ !empty($component['columns']) ? $component['columns'] : '3' }} {{ $component['gridGap'] ?? 'gap-x-4 gap-y-2' }} mt:mx-0 items-start">
    @foreach($data as $button)
        <li class="block text-center">
            @if(!empty($button['option']) && $button['option'] === 'Image')
                @include('components.buttons.image', ['button' => $button, 'class' => (!empty($component['columns']) && $component['columns'] === 1 ? '' : 'w-full').' '.($component['class'] ?? 'text-lg')])
            @elseif(!empty($button['option']) && $button['option'] != 'Default')
                @include('components.buttons.default', ['button' => $button, 'class' => (!empty($component['columns']) && $component['columns'] === 1 ? '' : 'w-full').' '.\Illuminate\Support\Str::slug($button['option']).'-button'.' '.($component['class'] ?? 'text-lg')])
            @else
                @include('components.buttons.default', ['button' => $button, 'class' => (!empty($component['columns']) && $component['columns'] === 1 ? '' : 'w-full').' '.($component['class'] ?? 'text-lg')])
            @endif
        </li>
    @endforeach
</ul>
