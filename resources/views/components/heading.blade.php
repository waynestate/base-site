{{--
    "heading":"Heading text",
    "headingLevel":["h2", "h3", "h4"],
    "headingClass":"text-green gold-divider"
--}}
@foreach($data as $item)
    @include('partials/heading', ['heading' => $item['heading'], 'headingLevel' => $component['headingLevel'] ?? '', 'headingClass' => !empty($component['headingClass']) ? $component['headingClass'].' mt-0 -mb-3' : 'mt-0 -mb-3'])
@endforeach
