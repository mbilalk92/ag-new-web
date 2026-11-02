@extends('layouts.app')

@section('content')
    <section class="feed-hero">
        <div class="feed-hero__intro">
            <p class="eyebrow">Barat &middot; Nikkah &middot; Valima &middot; Mehndi</p>
            <h1 class="h1">Groom's wear, worn once, remembered always.</h1>
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
                <div class="feed__item">
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
