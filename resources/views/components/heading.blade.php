{{--
    Label: "heading-1"
    Data: {
    "heading": "My heading"
    }
--}}

@foreach ($data as $item)
    <h2 class="mt-0 -mb-3" id="{{ Str::slug($item['heading']) }}">{{ $item['heading'] }}</h2>
@endforeach
