{{--
    $item => array // ['title', 'link', 'excerpt', 'relative_url', 'filename_alt_text']
--}}
<div class="tabs">
    @include('components.accordion', ['data' => $data])

    <div class="tabs__area js-tabArea">
        <ul class="tabs__nav js-tabNav" role="tablist" aria-label="Promo Tabs">
            @foreach($data as $item)
                <li @class([
                        'tabs__nav-item',
                        'lg:w-1/' . $loop->count,
                        'active' => $loop->first
                    ]) role="presentation">

                    <a class="tabs__nav-link"
                       id="tab-link-{{ $item['promo_item_id'] }}"
                       role="tab"
                       aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                       aria-controls="tab-{{ $item['promo_item_id'] }}"
                       tabindex="{{ $loop->first ? '0' : '-1' }}"
                       href="#definition-{{ $item['promo_item_id'] }}"
                       data-target="#tab-{{ $item['promo_item_id'] }}">
                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tabs__pane">
            @foreach($data as $item)
                <div @class(['tabs__pane-content', 'active' => $loop->first])
                     id="tab-{{ $item['promo_item_id'] }}"
                     role="tabpanel"
                     aria-labelledby="tab-link-{{ $item['promo_item_id'] }}"
                     tabindex="0">

                    <div @class([
                         'content',
                         'tabs__pane-description',
                         'tabs__pane-description--left' => !empty($item['option']) && $item['option'] == "Left",
                         'tabs__pane-description--center' => !empty($item['option']) && $item['option'] == "Center",
                         ])>

                        <div class="content">{!! $item['description'] !!}</div>

                        @if(!empty($item['relative_url']))
                            <figure @class([
                                 'tabs__figure',
                                 'tabs__figure--center' => !empty($item['option']) && $item['option'] == "Center",
                                 ])>
                                <img src="{{ $item['relative_url'] }}" alt="{{ $item['filename_alt_text'] }}">
                                @if(!empty($item['excerpt']))<figcaption>{{ $item['excerpt'] }}</figcaption>@endif
                            </figure>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
