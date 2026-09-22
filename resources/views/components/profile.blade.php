{{--
$profile => array // ['First Name, Last Name, Title, link']
--}}
<a href="{{ $profile['link'] }}" class="group block">
    <div class="aspect-portrait mb-1">
        @image(!empty($profile['data']['Picture']['url']) ? $profile['data']['Picture']['url'] : '/_resources/images/no-photo.svg', '', 'h-full w-full object-cover object-center')
    </div>
    <div class="underline group-hover:no-underline group-focus:no-underline font-bold">{{ $profile['full_name'] }}</div>
</a>
@if(!empty(config('base.profile.listing_fields')))
    @foreach (config('base.profile.listing_fields') as $name)
        @if(!empty($profile['data'][$name]))
            @include('components.profile-field', ['field' => $name, 'data' => $profile['data'][$name], 'tag' => 'div', 'class' => 'text-black text-sm'])
        @endif
    @endforeach
@endif
