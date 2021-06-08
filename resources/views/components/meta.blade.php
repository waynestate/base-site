<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="Author" content="Wayne State University">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="Keywords" content="{{ !empty($page['keywords']) ? $page['keywords'] : '' }}">
<meta name="Description" content="{{ !empty($page['description']) ? $page['description'] : '' }}">

<meta property="og:title" content="{{ !empty($page['title']) ? $page['title'] : '' }}">
<meta property="og:image" content="{{ !empty($meta['image']) ? $meta['image'] : config('base.meta_image') }}">
<meta property="og:image:alt" content="{{ !empty($meta['image_alt']) ? $meta['image_alt'] : config('base.meta_image_alt') }}">
<meta property="og:description" content="{{ !empty($page['description']) ? $page['description'] : '' }}">
<meta property="og:url" content="{{ !empty($server['url']) ? $server['url'] : '' }}">
<meta property="og:type" content="article" />
<meta property="og:updated_time" content="{{ !empty($page['updated-at']) ? $page['updated-at'] : '' }}">
<meta property="og:site_name" content="{{ !empty($site['title']) ? $site['title'] : '' }}">

@if(!empty(config('base.facebook_profile_id')))
<meta property="fb:profile_id" content="{{ config('base.facebook_profile_id') }}">
@endif

@if(!empty(config('base.facebook_app_id')))
<meta property="fb:app_id" content="{{ config('base.facebook_app_id') }}">
@endif

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{  !empty($page['title']) ? $page['title'] : ''  }}">
<meta name="twitter:description" content="{{ !empty($page['description']) ? $page['description'] : '' }}">
<meta name="twitter:url" content="{{ !empty($server['url']) ? $server['url'] : '' }}">
<meta name="twitter:site" content="{{ config('base.twitter_handle') }}">
<meta name="twitter:image" content="{{ !empty($meta['image']) ? $meta['image'] : config('base.meta_image') }}">
<meta name="twitter:image:alt" content="{{ !empty($meta['image_alt']) ? $meta['image_alt'] : config('base.meta_image_alt') }}">
<meta property="article:published_time" content="{{ !empty($page['updated-at']) ? $page['updated-at'] : '' }}">
