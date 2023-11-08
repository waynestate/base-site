{{--
    $button => array // ['title', 'link']
--}}
<div class="grid gap-y-4 xl:mx-0 items-start">
    @foreach($data as $button)
        <a href="{{ $button['link'] }}" class="green-button text-lg w-full mb-0">{{ $button['title'] }}</a>
    @endforeach
</div>
