<div class="col-span-2 grid md:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-2 mx-4 xl:mx-0 items-start">
    @foreach($data as $button)
        <a href="{{ $button['link'] }}" class="green-button text-lg w-full mb-0">{{ $button['title'] }}</a>
    @endforeach
</div>
