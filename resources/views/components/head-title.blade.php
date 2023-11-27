@php
    $titles = [];
    $char_length = 0;

    // Page title (except homepages)
    if (!empty($base['page']['title']) 
        && $base['server']['path'] != '/' 
        && $base['server']['path'] != rtrim($base['site']['subsite-folder'], '/')
    ) {
        $titles[] = $base['page']['title'];
        $char_length += strlen($base['page']['title']);
    }

    // Site title (if there is enough room)
    if (($char_length + 22) < 60) {
        $titles[] = $base['site']['title'];
        $char_length += strlen($base['site']['title']);
    }

    // University name (if there is room)
    if (($char_length + 22) <= 70) {
        $titles[] = 'Wayne State University';
    }

    // Display with dash separators
    echo implode(' - ', $titles);
@endphp