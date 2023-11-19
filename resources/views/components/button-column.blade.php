{{--
    $button => array // ['title', 'link']
--}}

<ul class="grid grid-cols-1 gap-4 gap-y-2 xl:mx-0 items-start">
    @foreach($data as $button)
        <li class="block">
            @if(!empty($button['option']) && $button['option'] === 'Image')
                @include('components.buttons.image', ['button' => $button, 'class' => 'w-full'])
            @elseif(!empty($button['option']) && $button['option'] != 'Default')
                @include('components.buttons.default', ['button' => $button, 'class' => 'w-full '.\Illuminate\Support\Str::slug($button['option']).'-button'])
            @else
                @include('components.buttons.default', ['button' => $button, 'class' => 'w-full'])
            @endif
        </li>
    @endforeach
</ul>
