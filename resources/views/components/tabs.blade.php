{{--
    $item => array // ['title', 'link', 'excerpt', 'relative_url', 'filename_alt_text']
--}}
<div class="tabs">
    @include('components.accordion', ['data' => $data])

    <div class="tabs__area js-tabArea">
        <ul class="tabs__nav js-tabNav">
            @foreach($data as $item)
                <li @class([
                        'tabs__nav-item',
                        'lg:w-1/' . $loop->count,
                        'active' => $loop->first
                    ])>
                    <a class="tabs__nav-link"
                       href="#definition-{{ $item['promo_item_id'] }}"
                       data-target="#tab-{{ $item['promo_item_id'] }}">
                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tabs__pane">
            @foreach($data as $item)
                <div @class(['tabs__pane-content', 'active' => $loop->first]) id="tab-{{ $item['promo_item_id'] }}">
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
