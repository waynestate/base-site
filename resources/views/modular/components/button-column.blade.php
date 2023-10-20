<div class="col-span-2 md:col-span-1">
    @if(!empty($data[0]['component']['heading']))<h2 class="mt-0">{{ $data[0]['component']['heading'] }}</h2>@endif
    <div class="grid gap-y-4 xl:mx-0 items-start">
        @foreach($data as $button)
            <a href="{{ $button['link'] }}" class="green-button text-lg w-full mb-0">{{ $button['title'] }}</a>
        @endforeach
    </div>
</div>
