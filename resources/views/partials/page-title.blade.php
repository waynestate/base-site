{{--
    // Replace title
    'title' => $article['data']['title']

    // Append string of class names
    'class' => 'text-green divider-gold' 
--}}
<h1 @class([$class ?? '', 'visually-hidden' => !config('base.show_page_title')])>{{ $title ?? $base['page']['title'] }}</h1>
