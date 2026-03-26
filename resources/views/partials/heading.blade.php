{{--
    "heading":"Heading text",
    "headingLevel":["h2", "h3", "h4"],
    "headingClass":"text-green divider-gold",
    "headingId":"optional-id-override"
--}}
@php $headingId = $headingId ?? Str::slug($heading); @endphp
@if (!empty($headingLevel) && strtolower($headingLevel) != 'h1')
    <{{ $headingLevel }} id="{{ $headingId }}" class="{{ $headingClass ?? '' }}">
        {!! strip_tags($heading, ['em', 'strong']) !!}
    </{{ $headingLevel }}>
@else
    <h2 id="{{ $headingId }}" class="{{ $headingClass ?? '' }}">
        {!! strip_tags($heading, ['em', 'strong']) !!}
    </h2>
@endif
