{{--
    $item => single // ['title', 'excerpt', 'description', 'link', 'filename_url', 'filename_alt_text']
--}}

@php
    // account for 1 item and no cols specified 
    // use list view ^

    if(empty($promo_item_class)) {
        $promo_item_class = '';

        if(!empty($component['columns']) && $component['columns'] == 1) {
            $promo_item_class = 'promo--list-item';
        } else {
            $promo_item_class = 'promo--grid-item';
        }
    }

    $catalog_classes = [];

    if(!empty($component['gradientOverlay']) && $component['gradientOverlay'] == true) {
        array_push($catalog_classes, 'catalog--gradient-overlay');
    }

    if(!empty($component['columns'])) {
        array_push($catalog_classes, 'catalog--cols-'.$component['columns']);
    }

    // doesn't work for sorted by option
    if(!empty($data[0])) {
        if(!empty($component['columns']) && (int)$component['columns'] % count($data) === 0 || empty($component['columns'])) {
            array_push($catalog_classes, 'catalog--one-row');
        }
    }

    if(!empty($component['columns']) && $component['columns'] > 4) {
        array_push($catalog_classes, 'catalog--multiple-rows');
    }

@endphp

@if(!empty($component['groupByOptions']) && $component['groupByOptions'] === true)
    @foreach($data as $group => $group_items)
        @if(!empty($group))
            @if(!empty($component['heading']))
                @include('partials/heading', [
                    'heading' => $group, 
                    'headingClass' => 'divider-gold pb-1 mt-6 ',
                    'headingLevel' => !empty($component['heading'])
                        ? (!empty($component['headingLevel']) ? $component['headingLevel'] : 'h3') 
                        : (!empty($component['headingLevel']) ? $component['headingLevel'] : 'h2')])
            @endif
        @else
            <hr class="border-gold border-b-2 mt-6" />
        @endif

        <ul @class(['catalog__grid', implode(' ', $catalog_classes) => !empty($catalog_classes)])>
            @foreach($group_items as $item)
                <li>
                @include('components/promo/item', ['class' => $promo_item_class])
                </li>
            @endforeach
        </ul>
    @endforeach
@else
    <ul @class(['catalog__grid', implode(' ', $catalog_classes) => !empty($catalog_classes)])>
        @foreach($data as $item)
            <li>
            @include('components/promo/item', ['class' => $promo_item_class])
            </li>
        @endforeach
    </ul>
@endif
