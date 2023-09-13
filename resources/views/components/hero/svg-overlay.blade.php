<div class="w-full relative overflow-hidden">
    @if(!empty($image['link']))<a href="{{  $image['link'] }}">@endif
        <div class="pt-hero w-full bg-cover bg-top {{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
        <div class="absolute print:relative inset-0 flex items-center justify-center">
            <img src="{{ $image['secondary_relative_url'] }}" alt="{{ $image['secondary_alt_text'] }}" class="w-full max-w-full max-h-full">
        </div>
    @if(!empty($image['link']))</a>@endif
</div>
