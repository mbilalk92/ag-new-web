@extends('layouts.app')

@section('title', $collection->meta_title ?: $collection->name . ' — Asian Groom')
@section('meta_description', $collection->meta_description ?: \Illuminate\Support\Str::limit($collection->description, 150))

@section('content')
    <section class="collection-hero">
        @if ($collection->has_video)
            <video class="collection-hero__video" autoplay muted loop playsinline preload="metadata">
                <source src="{{ $collection->video_embed_url }}">
            </video>
        @endif
        <div class="collection-hero__overlay"></div>
        <div class="collection-hero__content">
            <p class="eyebrow">Collection</p>
            <h1 class="h1">{{ $collection->name }}</h1>
            @if ($collection->description)
                <p class="body">{{ $collection->description }}</p>
            @endif
        </div>
    </section>

    <div class="container collection-page">
        <div class="shop__grid">
            @forelse ($collection->products as $product)
                @include('partials.product-card', ['product' => $product])
            @empty
                <p class="body">Pieces from this collection are coming soon.</p>
            @endforelse
        </div>
    </div>
@endsection
