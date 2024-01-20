{{--
    Label: "page-heading-1"
    Data: {
    "heading": "My heading"
    }
--}}

@foreach ($data as $heading)
    <h2 class="mt-0 -mb-3">{{ $heading['title'] }}</h2>
@endforeach
