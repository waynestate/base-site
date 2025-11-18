{{--
    // Replace title
    'title' => $article['data']['title']

    // Append string of class names
    'class' => 'text-green-500 divider-gold'
--}}
<h1 @class([$class ?? '', 'visually-hidden' => (isset($base['page_config']['showPageTitle']) ? !$base['page_config']['showPageTitle'] : false)])>{{ $title ?? $base['page']['title'] }}</h1>
