{{--
    $images => array // ['relative_url']
--}}

<div class="mt:mx-0{{ !empty($images) && count($images) > 1 ? ' rotate' : '' }}{{ !empty($show_site_menu) && $show_site_menu === true ? ' contained -mx-4' : ' full' }}">
    @foreach($images as $image)
        <div class="pt-partial w-full bg-cover bg-top relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif>
            @if(!empty($image['excerpt']) && config('app.hero_text_enabled') && in_array($page['controller'], config('app.hero_text_controllers')))
                <div class="bg-green-darker text-white py-4 lg:absolute pin-b pin-l pin-r">
                    <div class="row px-4">
                        {{ $image['excerpt'] }} @if(!empty($image['link'])) <a href="{{ $image['link'] }}" class="text-white underline font-bold pl-2 hover:no-underline">{{ config('app.hero_text_more') }}</a>@endif
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div>
