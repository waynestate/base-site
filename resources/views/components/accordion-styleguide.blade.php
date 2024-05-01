{{--
    $items => array // ['title', 'description']
--}}
<ul class="accordion">
    @foreach($data as $item)
        <li>
            <a href="#definition-{{ $item['promo_item_id'] }}" id="definition-{{ $item['promo_item_id'] }}"><span aria-hidden="true"></span>{{ $item['title'] }}</a>
            <div class="content">
                <p>{!! $item['description'] !!}</p>

                <table style="cell-padding: 5px;" class="{{ $loop->first ? 'no-stripe' : '' }}">
                    @if($item['promo_item_id'] === 'componentConfiguration')
                        <thead>
                            <tr>
                                <th class="md:w-2/5">Page field</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tr>
                            @foreach($item as $key => $detail)
                                @if($key != 'title' && $key != 'description' && $key != 'promo_item_id')
                                    <td>
                                        {!! $detail !!}
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endif
                    @if($item['promo_item_id'] === 'promoGroupDetails')
                        <thead>
                            <tr>
                                <th colspan="2">Available fields</th>
                            </tr>
                        </thead>
                        @foreach($item as $key => $detail)
                            @if($key != 'title' && $key != 'description' && $key != 'promo_item_id')
                            <tr>
                                <td class="font-bold">{{ $key }}</td>
                                <td>{!! $detail !!}</td>
                            </tr>
                            @endif
                        @endforeach
                    @endif
                </table>
            </div>
        </li>
    @endforeach
</ul>
