{{--
    $item => single // ['title', 'excerpt', 'description', 'link', 'filename_url', 'filename_alt_text']
--}}

<div class="catalog">
    @if(!empty($component['groupByOptions']) && $component['groupByOptions'] === true)
        @foreach($data as $group => $group_items)
            @if(!empty($group) && $group != 'Heading')
                @if(!empty($group) && $group != 'items')
                    @if(!empty($component['heading']))
                        @include('partials/heading', [$component['heading'] => $group, 'headingClass' => 'divider-gold pb-1 mt-6 '])
                    @else
                    @endif
                @else
                    @if(count($data) > 2)
                        <hr class="border-gold border-b-2 mt-6" />
                    @endif
                @endif

                @if(!empty($component['columns']) && $component['columns'] == 1)
                    <div class="catalog__grid grid {{ $component['catalogClass'] ?? 'gap-8 mt-6' }}">
                        @foreach($group_items as $item)
                            @include('components/promo/list-item', [$component['imageSize'] = 'small'])
                        @endforeach
                    </div>
                @else
                    <div class="catalog__grid grid {{ $component['catalogClass'] ?? 'gap-8 mt-6' }} {{ !empty($component['columns']) && $component['columns'] % 2 == 0 ? ($component['columns'] >= 4 ? ' grid-cols-2' : ' sm-grid-cols-2').' md:grid-cols-3 xl:grid-cols-'.($component['columns']) : ' sm:grid-cols-2 md:grid-cols-3' }}"> 
                        @foreach($group_items as $item)
                            @include('components/promo/grid-item')
                        @endforeach
                    </div>
                @endif
            @endif
        @endforeach
    @else
        @if(!empty($component['columns']) && $component['columns'] == 1)
            <div class="catalog__grid grid {{ $component['catalogClass'] ?? 'gap-8' }}">
                @foreach($data as $item)
                    @include('components/promo/list-item', [$component['imageSize'] = 'small'])
                @endforeach
            </div>
        @else
            <div class="catalog__grid grid {{ $component['catalogClass'] ?? 'gap-8' }} {{ !empty($component['columns']) && $component['columns'] % 2 == 0 ? (count($data) >= 4 ? ' sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-'.($component['columns']) : ' md:grid-cols-'.$component['columns']) : (count($data) >= 3 ? ' sm:grid-cols-1 md:grid-cols-3' : ' md:grid-cols-3') }}"> 
                @foreach($data as $item)
                    @include('components/promo/grid-item')
                @endforeach
            </div>
        @endif
    @endif
</div>
