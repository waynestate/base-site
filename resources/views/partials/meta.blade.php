<meta name="Keywords" content="{{ isset($page['keywords']) ? $page['keywords'] : '' }}" />
<meta name="Description" content="{{ isset($page['description']) ? $page['description'] : '' }}" />
<meta http-equiv="last-modified" content="{{ isset($page['updated-at']) ? $page['updated-at'] : '' }}" />

<meta property="og:title" content="{{ isset($page['title']) ? $page['title'] : '' }}" />
<meta property="og:image" content="{{ isset($meta['image']) ? $meta['image'] : '' }}" />
<meta property="og:image:alt" content="{{ isset($meta['image_alt']) ? $meta['image_alt'] : '' }}" />
<meta property="og:description" content="{{ isset($page['description']) ? $page['description'] : '' }}" />
<meta property="og:url" content="{{ isset($server['url']) ? $server['url'] : '' }}" />
<meta property="og:type" content="article" />
<meta property="og:updated_time" content="{{ isset($page['updated-at']) ? $page['updated-at'] : '' }}" />
<meta property="og:site_name" content="{{ isset($site['title']) ? $site['title'] : '' }}" />

@if(config('app.facebook_profile_id') !== null)
<meta property="fb:profile_id" content="{{ config('app.facebook_profile_id') }}" />
@endif

@if(config('app.facebook_app_id') !== null)
<meta property="fb:app_id" content="{{ config('app.facebook_app_id') }}" />
@endif

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{  isset($page['title']) ? $page['title'] : ''  }}">
<meta name="twitter:description" content="{{ isset($page['description']) ? $page['description'] : '' }}">
<meta name="twitter:url" content="{{ isset($server['url']) ? $server['url'] : '' }}">
<meta name="twitter:site" content="@waynestate">
<meta name="twitter:image" content="{{ isset($meta['image']) ? $meta['image'] : '' }}">
<meta property="article:published_time" content="{{ isset($page['updated-at']) ? $page['updated-at'] : '' }}" />
