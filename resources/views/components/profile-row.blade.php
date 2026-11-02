{{--
$profile => array // ['First Name, Last Name, Title, link']
$headingLevel => string // 'h2' or 'h3', default 'h2'
--}}
@php
    $headingTag = (!empty($headingLevel) && in_array(strtolower($headingLevel), ['h2', 'h3', 'h4'])) ? strtolower($headingLevel) : 'h2';
@endphp
<div class="flex gap-x-4 md:gap-x-6 items-start">
    <div class="w-1/3 md:w-1/4 shrink-0">
        <a href="{{ $profile['link'] }}" class="block aspect-portrait">
            @image(!empty($profile['data']['Picture']['url']) ? $profile['data']['Picture']['url'] : '/_resources/images/no-photo.svg', '', 'h-full w-full object-cover object-center')
        </a>
    </div>
    <div class="grow content">
        <{{ $headingTag }} class="text-2xl mt-0 mb-1 leading-tight font-bold">
            <a href="{{ $profile['link'] }}" class="underline hover:no-underline focus:no-underline">
                {{ $profile['full_name'] }}
            </a>
        </{{ $headingTag }}>

        @if(!empty(config('base.profile.listing_fields')))
            @foreach (config('base.profile.listing_fields') as $name)
                @if(!empty($profile['data'][$name]))
                    @include('components.profile-field', ['field' => $name, 'data' => $profile['data'][$name], 'tag' => 'div', 'class' => 'text-black text-sm'])
                @endif
            @endforeach
        @endif
    </div>
</div>
