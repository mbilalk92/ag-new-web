@extends('layouts.app')

@section('content')
    <section class="home-hero">
        @if ($settings->home_banner_has_video || $fallbackBannerVideoUrl)
            <video class="home-hero__video" autoplay muted loop playsinline preload="metadata">
                <source src="{{ $settings->home_banner_video_embed_url ?: $fallbackBannerVideoUrl }}">
            </video>
        @elseif ($settings->home_banner_image_url)
            <img class="home-hero__image" src="{{ $settings->home_banner_image_url }}" alt="{{ $settings->home_banner_heading ?: $settings->site_name }}">
        @endif
        <div class="home-hero__overlay"></div>
        <div class="home-hero__content">
            <p class="eyebrow">{{ $settings->home_banner_eyebrow ?: 'Barat · Nikkah · Valima · Mehndi' }}</p>
            <h1 class="h1">{{ $settings->home_banner_heading ?: "Groom's wear, worn once, remembered always." }}</h1>
            @if ($settings->home_banner_subheading)
                <p class="body">{{ $settings->home_banner_subheading }}</p>
            @endif
        </div>
    </section>

    <section class="home-intro">
        <div class="container home-intro__grid">
            <div class="home-intro__col">
                <p class="eyebrow">Bespoke groom's wear</p>
                <h2 class="h2">Sherwanis built for the barat, not just the photographs.</h2>
                <p class="body">Asian Groom designs and hand-finishes wedding sherwanis, kurtas, and waistcoats for grooms in Karachi and across Pakistan. Each piece is cut to measure and embroidered with traditional zardozi and dabka work, so it holds its shape through a full day of barat, nikkah, and valima functions — not just a photoshoot.</p>
            </div>
            <div class="home-intro__col">
                <p class="eyebrow">One wardrobe, every function</p>
                <h2 class="h2">From nikkah sherwani to valima suit, in one place.</h2>
                <p class="body">Shop groom's sherwanis for nikkah, statement pieces for the barat, lighter kurtas for mehndi, and tailored suits for valima — organised by occasion so you can plan your wedding wardrobe in one visit. Every collection is finished in-house in Karachi and ships with sizing support for a fit that's right the first time.</p>
            </div>
        </div>
    </section>

    <section class="feed-hero">
        <div class="feed-hero__intro">
            <p class="eyebrow">Shop by occasion</p>
            <h2 class="h2">Browse the latest pieces</h2>
        </div>

        <div class="feed-filters">
            <a href="{{ route('home') }}" class="feed-filters__chip is-active">All</a>
            @foreach ($occasions as $occasion)
                <a href="{{ route('shop.index', ['occasion' => $occasion->slug]) }}" class="feed-filters__chip">{{ $occasion->name }}</a>
            @endforeach
            <span class="feed-filters__divider"></span>
            @foreach ($categories as $category)
                <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="feed-filters__chip feed-filters__chip--ghost">{{ $category->name }}</a>
            @endforeach
        </div>

        <div class="feed">
            @foreach ($products as $product)
                <div class="feed__item reveal">
                    @include('partials.feed-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </section>

    @if ($bundles->count())
        <section class="bundle-strip">
            <div class="container">
                <div class="bundle-strip__header">
                    <div>
                        <p class="eyebrow">Tailored sets</p>
                        <h2 class="h2">Wedding bundles</h2>
                    </div>
                    <a href="{{ route('bundle.index') }}" class="btn btn--outline">View all bundles</a>
                </div>
                <div class="shop__grid">
                    @foreach ($bundles as $bundle)
                        @include('partials.bundle-card', ['bundle' => $bundle])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="brand-strip">
        <div class="brand-strip__inner">
            <div>
                <h2 class="h2">Made for the one day that stays in every photograph.</h2>
                <p class="body">Every sherwani is hand-finished in Karachi, built to carry zardozi and dabka embroidery through a full day of barat, nikkah, and valima without losing its shape.</p>
                <a href="{{ route('shop.index') }}" class="btn btn--primary">Browse the collection</a>
            </div>
        </div>
    </section>
@endsection
