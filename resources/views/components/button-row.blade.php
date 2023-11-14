{{--
    $button => array // ['title', 'link']
--}}

<div class="grid md:grid-cols-2 lg:grid-cols-{{ !empty($component['columns']) && $component['columns'] >= 4 ? '2' : '3' }} xl:grid-cols-{{ !empty($component['columns']) ? $component['columns'] : '3' }} xl:mx-0 items-start gap-x-4 gap-y-2">
    @foreach($data as $button)
        <a href="{{ $button['link'] }}" class="green-button text-lg w-full mb-0">{{ $button['title'] }}</a>
    @endforeach
</div>
