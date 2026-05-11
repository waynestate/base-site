{{--
    $button => array // ['title', 'link']
--}}

<ul @class([
    'buttons',
    'buttons--cols-'.($component['columns'] ?? 3),
    'buttons--odd' => (($component['columns'] ?? 3) % 2 != 0),
    ])>
    @foreach($data as $button)
        <li class="block text-center">
            @if(!empty($button['option']) && $button['option'] === 'Image')
                @include('components.buttons.image', ['button' => $button, 'class' => (!empty($component['columns']) && $component['columns'] === 1 ? '' : 'w-full').' text-lg'])
            @elseif(!empty($button['option']) && $button['option'] != 'Default')
                @include('components.buttons.default', ['button' => $button, 'class' => (!empty($component['columns']) && $component['columns'] === 1 ? '' : 'w-full').' text-lg '.\Illuminate\Support\Str::slug($button['option']).'-button'])
            @else
                @include('components.buttons.default', ['button' => $button, 'class' => (!empty($component['columns']) && $component['columns'] === 1 ? '' : 'w-full').' text-lg'])
            @endif
        </li>
    @endforeach
</ul>
