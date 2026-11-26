<!doctype html>
<html lang="en">
<head>
    @php
        $siteSettings = \App\Models\SiteSetting::current();
        $pageTitle = trim($__env->yieldContent('title')) ?: $siteSettings->default_meta_title;
        $pageDescription = trim($__env->yieldContent('meta_description')) ?: $siteSettings->default_meta_description;
        $pageImage = trim($__env->yieldContent('og_image')) ?: $siteSettings->og_image_url;
    @endphp

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteSettings->site_name }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    @if ($pageImage)
        <meta property="og:image" content="{{ $pageImage }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">

    @if ($siteSettings->google_site_verification)
        <meta name="google-site-verification" content="{{ $siteSettings->google_site_verification }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    @if ($siteSettings->google_analytics_id)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteSettings->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $siteSettings->google_analytics_id }}');
        </script>
    @endif

    @if ($siteSettings->meta_pixel_id)
        <script>
            !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $siteSettings->meta_pixel_id }}');
            fbq('track', 'PageView');
        </script>
    @endif
</head>
<body>
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.cart-drawer')
    @include('partials.lightbox')
    @include('partials.floating-actions')
</body>
</html>
