{{--
    $item => single // ['title', 'excerpt', 'description', 'link', 'filename_url', 'filename_alt_text']
--}}

@php
    $promo_item_class = '';

    if(!empty($component['columns']) && $component['columns'] == 1) {
        $promo_item_class = 'promo--list-item';
    } else {
        $promo_item_class = 'promo--grid-item';
    }

    $catalog_classes = [];

    if(!empty($component['columns']) && $component['columns'] >= 4) {
        array_push($catalog_classes, 'catalog--multiple-rows');
    }

    if(!empty($component['columns']) && $component['columns'] < 4) {
        array_push($catalog_classes, 'catalog--one-row');
    }

    if(!empty($component['columns']) && $component['columns'] % 2 == 0) {
        array_push($catalog_classes, 'catalog--even-items xl:grid-cols-'.$component['columns']);
    }

    if(!empty($component['columns']) && $component['columns'] % 2 != 0) {
        array_push($catalog_classes, 'catalog--odd-items xl:grid-cols-'.$component['columns']);
    }

@endphp

@if(!empty($component['groupByOptions']) && $component['groupByOptions'] === true)
    @foreach($data as $group => $group_items)
        @if(!empty($group))
            @if(!empty($component['heading']))
                @include('partials/heading', ['heading' => $group, 
                                              'headingClass' => 'divider-gold pb-1 mt-6 ',
                                              'headingLevel' => !empty($component['heading'])
                                                  ? (!empty($component['headingLevel']) ? $component['headingLevel'] : 'h3') 
                                                  : (!empty($component['headingLevel']) ? $component['headingLevel'] : 'h2')])
            @endif
        @else
            <hr class="border-gold border-b-2 mt-6" />
        @endif

        <div @class(['catalog__grid', implode(' ', $catalog_classes) => !empty($catalog_classes)])>
            @foreach($group_items as $item)
                @include('components/promo/grid-item', ['class' => $promo_item_class])
            @endforeach
        </div>
    @endforeach
@else
    <div @class(['catalog__grid', implode(' ', $catalog_classes) => !empty($catalog_classes)])>
        @foreach($data as $item)
            @include('components/promo/grid-item', ['class' => $promo_item_class])
        @endforeach
    </div>
@endif
