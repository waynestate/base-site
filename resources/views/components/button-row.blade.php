{{--
    $button => array // ['title', 'link']
--}}

<ul class="grid  md:grid-cols-{{ !empty($component['columns']) && count($data) % 2 == 0 ? '2' : '3' }} xl:grid-cols-{{ !empty($component['columns']) ? $component['columns'] : '3' }} xl:mx-0 items-start gap-x-4 gap-y-2">
    @foreach($data as $button)
        <li class="block">
            @if(!empty($button['option']) && $button['option'] === 'Image')
                @include('components.buttons.image', ['button' => $button, 'class' => 'w-full text-lg'])
            @elseif(!empty($button['option']) && $button['option'] != 'Default')
                @include('components.buttons.default', ['button' => $button, 'class' => 'w-full text-lg '.\Illuminate\Support\Str::slug($button['option']).'-button'])
            @else
                @include('components.buttons.default', ['button' => $button, 'class' => 'w-full text-lg'])
            @endif
        </li>
    @endforeach
</ul>
