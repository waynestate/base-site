@php
    $data = $data ?? null;
    $tag = $tag ?? null;
    $class = $class ?? null;
    $link = $link ?? true;
    $urlFields = config('base.profile.url_fields', ['Website']);
    $fileFields = config('base.profile.file_fields', ['Curriculum Vitae', 'Syllabi']);

    if ($field === 'Youtube Videos') {
        $items = is_array($data) ? $data : [$data];
    } elseif (in_array($field, $fileFields) || (is_array($data) && isset($data['url']))) {
        $items = isset($data['url']) ? [$data] : (is_array($data) ? $data : []);
    } elseif (is_array($data)) {
        $items = $data;
    } else {
        $items = [$data];
    }

    $items = array_filter($items);
@endphp
@foreach ($items as $item)
    @if ($field === 'Youtube Videos')
        <div class="{{ !empty($class) ? $class : 'pb-4' }}">
            @if ($link && !empty($item['link']))
                <a href="{{ $item['link'] }}">@image('//i.wayne.edu/youtube/' . $item['youtube_id'], $item['filename_alt_text'], 'lazy')</a>
            @else
                @image('//i.wayne.edu/youtube/' . $item['youtube_id'], $item['filename_alt_text'], 'lazy')
            @endif
        </div>
    @else
        @if (!empty($tag))
            <{{ $tag }}{!! !empty($class) ? ' class="' . $class . '"' : '' !!}>
        @endif
        @if (in_array($field, $fileFields) || (is_array($item) && isset($item['url'])))
            @if ($link && !empty($item['url']))
                <a href="{{ $item['url'] }}">{{ $field }}</a>@else{{ $field }}
            @endif
        @elseif($field === 'Email')
            @if ($link)
                <a href="mailto:{{ $item }}">{{ $item }}</a>@else{{ $item }}
            @endif
        @elseif($field === 'Fax')
            {!! strip_tags($item) !!} (fax)
        @elseif(in_array($field, $urlFields))
            @if ($link)
                <a href="{{ $item }}">{{ $item }}</a>@else{{ $item }}
            @endif
        @else{!! strip_tags($item, '<br>') !!}
        @endif
        @if (!empty($tag))
            </{{ $tag }}>
        @endif
    @endif
@endforeach
