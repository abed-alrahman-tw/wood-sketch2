<title>{{ $seo['title'] ?? config('app.name') }}</title>
<meta name="description" content="{{ $seo['description'] ?? '' }}">
<meta property="og:title" content="{{ $seo['title'] ?? '' }}">
<meta property="og:description" content="{{ $seo['description'] ?? '' }}">
<meta property="og:url" content="{{ $seo['url'] ?? url()->current() }}">
<meta property="og:site_name" content="{{ $seo['site_name'] ?? config('app.name') }}">
<meta property="og:type" content="website">
@if(!empty($seo['image']))
<meta property="og:image" content="{{ $seo['image'] }}">
<meta name="twitter:card" content="summary_large_image">
@else
<meta name="twitter:card" content="summary">
@endif
<meta name="twitter:title" content="{{ $seo['title'] ?? '' }}">
<meta name="twitter:description" content="{{ $seo['description'] ?? '' }}">
@if(!empty($seo['image']))
<meta name="twitter:image" content="{{ $seo['image'] }}">
@endif
