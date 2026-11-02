@extends('layouts.app')

@section('title', 'Client Diaries — Asian Groom')
@section('meta_description', 'Real grooms, real functions — a look back at Asian Groom clients on their barat, nikkah, valima, and mehndi days.')

@section('content')
    <div class="feed-hero">
        <div class="feed-hero__intro">
            <p class="eyebrow">Real clients, real functions</p>
            <h1 class="h1">Client diaries.</h1>
            <p class="body">A look back at grooms who trusted us with their barat, nikkah, valima, and mehndi looks.</p>
        </div>

        <div class="feed">
            @forelse ($photos as $photo)
                <div class="feed__item">
                    <div class="feed-card feed-card--static"
                         data-lightbox-group="client-diaries"
                         data-lightbox-src="{{ asset('storage/' . $photo->path) }}"
                         data-lightbox-alt="{{ $photo->caption ?? 'Asian Groom client' }}">
                        <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->caption ?? 'Asian Groom client' }}" loading="lazy" width="{{ $photo->width }}" height="{{ $photo->height }}">
                        @if ($photo->caption)
                            <span class="feed-card__overlay">
                                <span class="feed-card__name">{{ $photo->caption }}</span>
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <p class="body">No client photos yet.</p>
            @endforelse
        </div>
    </div>
@endsection
