{{--
    $item => single // ['title', 'excerpt', 'description', 'link', 'filename_url', 'filename_alt_text']
--}}

<section>
    @if(!empty($component['groupByOptions']) && $component['groupByOptions'] === true)
        @foreach($data as $group => $group_items)
            @if(!empty($group))
                @if(!empty($component['heading']))
                    <h3 class="border-solid border-b-2 pb-1 border-gold mt-6 mt-4">{{ $group }}</h3>
                @else
                    <h2 class="border-solid border-b-2 pb-1 border-gold mt-6 mt-4">{{ $group }}</h2>
                @endif
            @else
                <hr class="border-gold border-b-2 mt-6" />
            @endif

            @if(!empty($component['columns']) && $component['columns'] == 1)
                <div class="grid gap-8 mt-6">
                    @foreach($group_items as $item)
                        @include('components/promo/list-item', [$component['imageSize'] = 'small'])
                    @endforeach
                </div>
            @else
                <div class="grid gap-8 mt-6 {{ !empty($component['columns']) && $component['columns'] % 2 == 0 ? ($component['columns'] >= 4 ? ' grid-cols-2' : ' sm-grid-cols-2').' md:grid-cols-3 xl:grid-cols-'.($component['columns']) : ' sm:grid-cols-2 md:grid-cols-3' }}"> 
                    @foreach($group_items as $item)
                        @include('components/promo/grid-item')
                    @endforeach
                </div>
            @endif
        @endforeach
    @else
        @if(!empty($component['columns']) && $component['columns'] == 1)
            <div class="grid gap-8 mt-6">
                @foreach($data as $item)
                    @include('components/promo/list-item', [$component['imageSize'] = 'small'])
                @endforeach
            </div>
        @else
            <div class="grid gap-8 mt-6 {{ !empty($component['columns']) && $component['columns'] % 2 == 0 ? (count($data) >= 4 ? ' sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-'.($component['columns']) : ' md:grid-cols-'.$component['columns']) : (count($data) >= 3 ? ' sm:grid-cols-1 md:grid-cols-3' : ' md:grid-cols-'.$component['columns']) }}"> 
                @foreach($data as $item)
                    @include('components/promo/grid-item')
                @endforeach
            </div>
        @endif
    @endif
</section>
