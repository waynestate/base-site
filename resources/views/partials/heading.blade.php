{{--
    "heading":"Heading text",
    "headingLevel":["h2", "h3", "h4"],
    "headingClass":"text-green gold-divider"
--}}

<div class="component__heading content">
    <{{ $component['heading']['level'] ?? 'h2' }} id="{{ Str::slug($component['heading']['title']) }}" class="{{ $component['heading']['class'] ?? '' }}">
        {!! strip_tags($component['heading']['title'], ['em', 'strong']) !!}
    </{{ $component['heading']['level'] ?? 'h2' }}>

    @if(!empty($component['heading']['description'])) 
        {!! $component['heading']['description'] !!}
    @endif
</div>
