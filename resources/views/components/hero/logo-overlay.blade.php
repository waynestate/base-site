<div class="mb-4 full min-h-hero relative overflow-hidden flex bg-green-900">
    <div class="inset-0 absolute print:relative bg-cover bg-top opacity-20 {{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
    <div class="w-full relative text-white flex flex-col justify-center">
        <div class="row w-full px-4 pt-10 pb-6 text-center md:white-links content">
            @if(!empty($image['secondary_relative_url']))<img class="mx-auto mb-4" src="{{ $image['secondary_relative_url'] }}" alt="{{ $image['secondary_alt_text'] }}">@endif
            <div class="md:text-shadow-darkest leading-tight text-2xl mb-1 @if(in_array($base['page']['controller'], config('base.hero_full_controllers')))xl:text-5xl @else xl:text-3xl @endif">{{ $image['title'] }}</div>
            @if(!empty($image['description']))<div class="md:text-lg">{!! $image['description'] !!}</div>@endif
        </div>
    </div>
</div>
