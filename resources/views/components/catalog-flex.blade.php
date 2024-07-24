{{--
    $item => single // ['title', 'excerpt', 'description', 'link', 'filename_url', 'filename_alt_text']
--}}

<div class="catalog">
    @if(!empty($component['groupByOptions']) && $component['groupByOptions'] === true)
        @foreach($data as $group => $group_items)
            @if(!empty($group) && $group != 'Heading')
                @if(!empty($group) && $group != 'items')
                    @if(!empty($component['heading']))
                        @include('partials/heading', ['heading' => $group, 'headingClass' => 'divider-gold pb-1 mt-6 ', 'headingLevel' => !empty($component['headingLevel']) ? $component['headingLevel'] : 'h3'])
                    @else
                        @include('partials/heading', ['heading' => $group, 'headingClass' => 'divider-gold pb-1 mt-6 '.($component['headingClass'] ?? ''), 'headingLevel' => !empty($component['headingLevel']) ? $component['headingLevel'] : 'h2'])
                    @endif
                @else
                    @if(count($data) > 2)
                        <hr class="border-gold border-b-2 mt-6" />
                    @endif
                @endif

                <div class="catalog__grid flex flex-wrap justify-center {{ $component['catalogClass'] ?? 'gap-y-8 gap-x-6 mt-6' }}"> 
                    @foreach($group_items as $item)
                        @include('components/promo/grid-item', [$component['promoItemClass'] = !empty($component['promoItemClass']) ? $component['promoItemClass'] : 'w-1/2 lg:w-1/4'])
                    @endforeach
                </div>
            @endif
        @endforeach
    @else
        <div class="catalog__grid flex flex-wrap justify-center {{ $component['catalogClass'] ?? 'gap-y-8 gap-x-6 mt-6' }}"> 
            @foreach($data as $item)
                @include('components/promo/grid-item', [$component['promoItemClass'] = !empty($component['promoItemClass']) ? $component['promoItemClass'] : 'w-1/2 lg:w-1/4'])
            @endforeach
        </div>
    @endif
</div>
