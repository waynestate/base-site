<div class="col-span-2 md:col-span-1">
    @if(!empty($data[0]['component']['heading']))<h2 class="mt-0">{{ $data[0]['component']['heading'] }}</h2>@endif
    <ul class="grid grid-cols-1 gap-6">
    @foreach($data as $step)
        <li>
            <a class="block group" href="{{ $step['link'] }}">
                <div class="flex gap-3">
                    <div class="w-16 grow-0 shrink-0">
                        @image($step['filename_url'], $step['filename_alt_text'], 'block mx-auto')
                    </div>
                    <div>
                        <h3 class="text-lg lg:text-base xl:text-xl mt-0 mb-1 underline group-hover:no-underline">{{ $step['title'] }}</h3>
                        <p class="text-base lg:text-sm xl:text-base text-black mb-0">{{ $step['excerpt'] }}</p>
                    </div>
                </div>
            </a>
        </li>
    @endforeach
    </ul>
</div>
