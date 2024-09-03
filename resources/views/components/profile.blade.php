{{--
    $profile => array // ['First Name, Last Name, Title, link']
--}}
<a href="{{ $profile['link'] }}" class="group">
    <div class="aspect-portrait mb-1">
        @image(!empty($profile['data']['Picture']['url']) ? $profile['data']['Picture']['url'] : '/_resources/images/no-photo.svg', $profile['data']['First Name'].' '.$profile['data']['Last Name'], 'h-full w-full object-cover object-center')
    </div>
    <div class="underline group-hover:no-underline group-focus:no-underline font-bold">{{ $profile['full_name'] }}</div>
    @if(!empty($profile['data']['Title']))
        <div class="text-black text-sm">{{ $profile['data']['Title'] }}</div>
    @endif
</a>
