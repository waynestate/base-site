<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="Author" content="Wayne State University">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="Keywords" content="{{ isset($page['keywords']) ? $page['keywords'] : '' }}">
<meta name="Description" content="{{ isset($page['description']) ? $page['description'] : '' }}">

<meta property="og:title" content="{{ isset($page['title']) ? $page['title'] : '' }}">
<meta property="og:image" content="{{ isset($meta['image']) ? $meta['image'] : '' }}">
<meta property="og:image:alt" content="{{ isset($meta['image_alt']) ? $meta['image_alt'] : '' }}">
<meta property="og:description" content="{{ isset($page['description']) ? $page['description'] : '' }}">
<meta property="og:url" content="{{ isset($server['url']) ? $server['url'] : '' }}">
<meta property="og:type" content="article" />
<meta property="og:updated_time" content="{{ isset($page['updated-at']) ? $page['updated-at'] : '' }}">
<meta property="og:site_name" content="{{ isset($site['title']) ? $site['title'] : '' }}">

@if(!empty(config('app.facebook_profile_id')))
<meta property="fb:profile_id" content="{{ config('app.facebook_profile_id') }}">
@endif

@if(!empty(config('app.facebook_app_id')))
<meta property="fb:app_id" content="{{ config('app.facebook_app_id') }}">
@endif

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{  isset($page['title']) ? $page['title'] : ''  }}">
<meta name="twitter:description" content="{{ isset($page['description']) ? $page['description'] : '' }}">
<meta name="twitter:url" content="{{ isset($server['url']) ? $server['url'] : '' }}">
<meta name="twitter:site" content="@waynestate">
<meta name="twitter:image" content="{{ isset($meta['image']) ? $meta['image'] : '' }}">
<meta property="article:published_time" content="{{ isset($page['updated-at']) ? $page['updated-at'] : '' }}">

<meta name="foundation-mq" content="foundation-mq" class="foundation-mq">
