@php 
    dump($data);
    die;
@endphp

<div>
    @include('components.events-column', ['item' => $item, 'loop' => $loop ?? ''])
    @include('components.news-column', ['item' => $item, 'loop' => $loop ?? ''])
</div>
