{{--
    $button => array // ['title', 'link']
--}}

<ul class="grid grid-cols-1 gap-4 gap-y-2 xl:mx-0 items-start">
    @foreach($data as $button)
        <li class="block">
            @if(!empty($button['option']) && view()->exists('components.buttons.'.\Illuminate\Support\Str::slug($button['option'])))
                @include('components.buttons.'.\Illuminate\Support\Str::slug($button['option']), ['button' => $button, 'class' => 'w-full'])
            @else
                @include('components.buttons.default', ['button' => $button, 'class' => 'w-full'])
            @endif
        </li>
    @endforeach
</ul>
