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

{{-- Wayne stuff to integrate
@if(!empty($heading['title']))
    <div class="component__heading">
        <{{ $heading['headingLevel'] ?? 'h2' }} 
            id="{{ $heading['headingId'] ?? '' }}" 
            @class([($heading['headingClass'] ?? '') => !empty($heading['headingClass'])])
        >
            {!! strip_tags($heading['title'], ['em', 'strong']) !!}
        </{{ $heading['headingLevel'] ?? 'h2' }}>

        @if(!empty($heading['description']))
            <div class="component__heading-description content">
                {!! $heading['description'] !!}
            </div>
        @endif
    </div>
@endif
--}}
