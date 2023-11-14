{{--
    $item => single // ['title', 'excerpt', 'description', 'link', 'filename_url', 'filename_alt_text']
--}}

@if(!empty($component['columns']) && $component['columns'] == 1)
    <div class="grid gap-4">
        @foreach($data as $item)
            @include('components/promo-list-item')
        @endforeach
    </div>
@else
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-{{ !empty($component['columns']) && $component['columns'] >= 3 ? '3' : '2' }} xl:grid-cols-{{ !empty($component['columns']) ? $component['columns'] : '3' }}">
        @foreach($data as $item)
            @include('components/promo-grid-item')
        @endforeach
    </div>
@endif
