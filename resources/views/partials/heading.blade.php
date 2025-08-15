{{--
    "heading":"Heading text",
    "headingLevel":["h2", "h3", "h4"],
    "headingClass":"text-green divider-gold"
--}}
@if (!empty($headingLevel) && strtolower($headingLevel) != 'h1')
    <{{ $headingLevel }} id="{{ Str::slug($heading) }}" class="{{ $headingClass ?? '' }}">
        {!! strip_tags($heading, ['em', 'strong']) !!}
    </{{ $headingLevel }}>
@else
    <h2 id="{{ Str::slug($heading) }}" class="{{ $headingClass ?? '' }}">
        {!! strip_tags($heading, ['em', 'strong']) !!}
    </h2>
@endif
