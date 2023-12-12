{{--
    $item => single // ['title', 'excerpt', 'description', 'link', 'filename_url', 'filename_alt_text']
--}}

<section>
    @if(!empty($component['groupByOptions']) && $component['groupByOptions'] === true)
        @foreach($data as $group => $group_items)
            @if(!empty($group))
                @if(!empty($component['heading']))
                    <h3 class="border-solid border-b-2 pb-1 border-gold my-4">{{ $group }}</h3>
                @else
                    <h2 class="border-solid border-b-2 pb-1 border-gold my-4">{{ $group }}</h2>
                @endif
            @else
                <hr class="border-gold border-b-2 my-4" />
            @endif

            @if(!empty($component['columns']) && $component['columns'] == 1)
                <div class="grid gap-6">
                    @foreach($group_items as $item)
                        @include('components/promo-list-item')
                    @endforeach
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-{{ !empty($component['columns']) && count($data) % 2 == 0 ? '2' : '3' }} xl:grid-cols-{{ !empty($component['columns']) ? $component['columns'] : '3' }}">
                    @foreach($group_items as $item)
                        @if(!empty($component['gradientOverlay']) && $component['gradientOverlay'] === true)
                            @include('components/promo-grid-item-gradient-overlay')
                        @else
                            @include('components/promo-grid-item')
                        @endif
                    @endforeach
                </div>
            @endif
        @endforeach
    @else
        @if(!empty($component['columns']) && $component['columns'] == 1)
            <div class="grid gap-6">
                @foreach($data as $item)
                    @include('components/promo-list-item')
                @endforeach
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-{{ !empty($component['columns']) && count($data) % 2 == 0 ? '2' : '3' }} xl:grid-cols-{{ !empty($component['columns']) ? $component['columns'] : '3' }}">
                @foreach($data as $item)
                    @if(!empty($component['gradientOverlay']) && $component['gradientOverlay'] === true)
                        @include('components/promo-grid-item-gradient-overlay')
                    @else
                        @include('components/promo-grid-item')
                    @endif
                @endforeach
            </div>
        @endif
    @endif
</section>
