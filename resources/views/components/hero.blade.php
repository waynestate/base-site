{{--
    $images => array // ['relative_url', 'title', 'description']
--}}

<div
    {!! (in_array($base['page']['controller'], config('base.hero_full_controllers'))) ? ' role="complementary"' : '' !!} 
    class="mb-4 mt:mx-0{{ !empty($images) && count($images) > 1 ? ' rotate' : '' }}{{!in_array($base['page']['controller'], config('base.hero_full_controllers'))  ? '  -mx-4' : ' ' }}"
>
    @foreach($images as $image)
        @if(!empty($image['option']))
            @include('components/hero/'.$image['option'])
        @else
            @include('components/hero/default')
    @endforeach
</div>
