{{--
    $hero => array // ['filename_url', 'title']
--}}
<div class="hero__wrapper w-full">
    <div class="hero__bg h-hero max-h-hero w-full bg-cover bg-center relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $hero['filename_url'] }}')" @else data-src="{{ $hero['filename_url'] }}"@endif></div>
</div>
