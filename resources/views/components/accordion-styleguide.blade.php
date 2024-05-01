{{--
    $items => array // ['title', 'description']
--}}
<ul class="accordion">
    @foreach($data as $item)
        <li>
            <a href="#definition-{{ $item['promo_item_id'] }}" id="definition-{{ $item['promo_item_id'] }}"><span aria-hidden="true"></span>{{ $item['title'] }}</a>
            <div class="content">
                {!! $item['description'] !!}

                <table style="cell-padding: 5px;" class="mt-4 {{ $loop->first ? 'no-stripe' : '' }}">
                    @if($item['promo_item_id'] === 'componentConfiguration')
                        <thead>
                            <tr>
                                <th class="md:w-2/5">Page field</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($item as $tr => $details)
                                @if(strpos($tr, 'tr') !== false)
                                    <tr>
                                        <td><pre class="w-full">{!! $details['Page field'] !!}</pre></td>
                                        <td><pre class="w-full">{!! $details['Data'] !!}</pre></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    @endif

                    @if($item['promo_item_id'] === 'promoGroupDetails')
                        <thead>
                            <tr>
                                <th colspan="2">Available fields</th>
                            </tr>
                        </thead>
                        @foreach($item['table'] as $key => $detail)
                            <tr>
                                <td class="font-bold">{{ $key }}</td>
                                <td>{!! $detail !!}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </li>
    @endforeach
</ul>
