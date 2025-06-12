{{--
    // Replace title
    'title' => $article['data']['title']

    // Append string of class names
    'class' => 'text-green divider-gold' 
--}}
<h1 @class([$class ?? '', 'visually-hidden' => (isset($base['layout_config']['show_page_title']) ? !$base['layout_config']['show_page_title'] : false)])>{{ $title ?? $base['page']['title'] }}</h1>
