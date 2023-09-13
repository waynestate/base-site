<div class="w-full">
    <div 
        class="pt-hero w-full bg-cover bg-top relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true)
        style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif>
    </div>
</div>
