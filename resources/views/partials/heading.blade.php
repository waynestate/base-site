{{--
    "heading":"Heading text",
    "headingLevel":["h2", "h3", "h4"],
    "headingClass":"text-green gold-divider"
--}}
<{{ !empty($headingLevel) && strtolower($headingLevel) != 'h1' ? $headingLevel : 'h2' }} id="{{ Str::slug($heading) }}" class="{{ $headingClass ?? '' }}">
    {!! strip_tags($heading, ['em', 'strong']) !!}
</{{ !empty($headingLevel) && strtolower($headingLevel) != 'h1' ? $headingLevel : 'h2' }}>
