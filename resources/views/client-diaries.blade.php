@extends('layouts.app')

@section('title', 'Client Diaries — Asian Groom')
@section('meta_description', 'Real grooms, real functions — a look back at Asian Groom clients on their barat, nikkah, valima, and mehndi days.')

@section('content')
    <div class="feed-hero">
        <div class="feed-hero__intro">
            <p class="eyebrow">Real clients, real functions</p>
            <h1 class="h1">Client diaries.</h1>
            <p class="body">A look back at grooms who trusted us with their barat, nikkah, valima, and mehndi looks. Spot something you like? Hover a photo and shop the look.</p>
        </div>

        @if (session('status'))
            <p class="alert alert--success">{{ session('status') }}</p>
        @endif

        <div class="feed" id="diary-feed" data-next-page="{{ $photos->hasMorePages() ? 2 : '' }}" data-more-url="{{ route('client-diaries.more') }}">
            @include('partials.client-diary-items', ['photos' => $photos])
        </div>

        <div class="feed-loader" id="feed-loader" hidden>
            <span class="feed-loader__spinner"></span> Loading more…
        </div>

        @if ($photos->hasMorePages())
            <button type="button" class="btn btn--outline feed-load-more" id="feed-load-more">Load more</button>
        @endif
    </div>

    @include('partials.shop-the-look-modal')
@endsection
