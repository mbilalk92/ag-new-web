<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>@yield('title', 'Asian Groom')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/scss/app.scss'])
</head>
<body>
    <main>
        <div class="error-page">
            <a href="{{ url('/') }}" class="error-page__logo">
                <img src="{{ asset('storage/site/logo-full.png') }}" alt="Asian Groom">
            </a>

            <p class="error-page__code">@yield('code')</p>
            <h1 class="h1">@yield('heading')</h1>
            <p class="body">@yield('message')</p>

            <div class="error-page__actions">
                <a href="{{ url('/') }}" class="btn btn--primary">Back to homepage</a>
                <a href="{{ url('/shop') }}" class="btn btn--outline">Shop the collection</a>
            </div>
        </div>
    </main>
</body>
</html>
