<div class="hero__wrapper w-full">
    <div 
        class="hero__bg pt-hero w-full bg-cover bg-top relative{{ $loop->first !== true ? ' lazy' : '' }}" 
        @if($loop->first === true) style="background-image: url('{{ $hero['relative_url'] }}')" @else data-src="{{ $hero['relative_url'] }}"@endif>
    </div>
</div>
