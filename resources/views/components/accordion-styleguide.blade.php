{{--
    $items => array // ['title', 'description']
--}}
<ul class="Accordion">
    @foreach($data as $item)
        <div class="h3 Accordion__heading" data-expanded="false">
            <button class="Accordion__toggle" aria-expanded="false">
                <div class="">{{ $item['title'] }}</div>
                <div class="transition-transform">
                    @svg('plus', 'Accordion__icon h-6')
                </div>
            </button>
        </div>
        <div class="Accordion__content">
            <div class="Accordion__wrapper">
                <div class="Accordion__interior flush content">
                    <p>{!! $item['description'] !!}</p>

                    <table style="cell-padding: 5px;">
                        @if($loop->first)
                            <tr>
                                <th class="md:w-2/5">Page field</th>
                                <th>Data</th>
                            </tr>
                            <tr>
                                @foreach($item as $key => $detail)
                                    @if($key != 'title' && $key != 'description')
                                        <td class="font-bold">{{ $key }}</td>
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($item as $key => $detail)
                                    @if($key != 'title' && $key != 'description')
                                        <td>{!! $detail !!}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @else
                            <tr>
                                <th colspan="2">Available fields</th>
                            </tr>
                            @foreach($item as $key => $detail)
                                @if($key != 'title' && $key != 'description')
                                <tr>
                                    <td class="font-bold">{{ $key }}</td>
                                    <td>{!! $detail !!}</td>
                                </tr>
                                @endif
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</ul>
