
{{--
    "heading":"Heading text",
    "headingLevel":["h2", "h3", "h4"],
    "headingClass":"text-green gold-divider"
--}}
<{{ $headingLevel ?? 'h2' }} id="{{ Str::slug($heading) }}" class="{{ $headingClass ?? '' }}">
    {!! strip_tags($heading, ['em', 'strong']) !!}
</{{ $headingLevel ?? 'h2' }}>
