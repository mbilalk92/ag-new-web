@extends('layouts.app')

@section('title', $bundle->meta_title ?: $bundle->name . ' — Asian Groom')
@section('meta_description', $bundle->meta_description ?: \Illuminate\Support\Str::limit($bundle->description, 150))
@section('og_image', $bundle->images->first() ? asset('storage/' . $bundle->images->first()->path) : '')

@section('content')
    <div class="container product-page">
        <nav class="breadcrumb">
            <a href="{{ route('bundle.index') }}">Bundles</a> /
            <span>{{ $bundle->name }}</span>
        </nav>

        <div class="product-page__layout">
            <div class="product-gallery">
                <div class="product-gallery__main" data-zoom-container>
                    <img src="{{ asset('storage/' . $bundle->images->first()?->path) }}" alt="{{ $bundle->name }}" id="gallery-main" data-gallery-main>
                    <span class="product-gallery__hint">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3" stroke-linecap="round"/><path d="M11 8v6M8 11h6" stroke-linecap="round"/></svg>
                        View gallery
                    </span>
                </div>
                @if ($bundle->images->count() > 1)
                    <div class="product-gallery__thumbs">
                        @foreach ($bundle->images as $image)
                            <button type="button" class="product-gallery__thumb" data-src="{{ asset('storage/' . $image->path) }}">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $bundle->name }}">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="product-details">
                <p class="eyebrow">Bundle</p>
                <h1 class="h1">{{ $bundle->name }}</h1>
                <p class="product-details__price price">
                    @if ($bundle->is_on_sale)
                        <s>Rs {{ number_format($bundle->compare_at_price) }}</s> Rs {{ number_format($bundle->price) }}
                    @else
                        Rs {{ number_format($bundle->price) }}
                    @endif
                </p>

                <p class="body">{{ $bundle->description }}</p>

                @if (! empty($bundle->included_items))
                    <ul class="bundle-items">
                        @foreach ($bundle->included_items as $item)
                            <li>
                                <strong>{{ $item['label'] }}</strong>
                                @if (! empty($item['description']))
                                    <span>{{ $item['description'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if ($bundle->video_embed_url)
                    <div class="product-video">
                        @if (preg_match('/\.(mp4|mov)(\?.*)?$/i', $bundle->video_embed_url))
                            <video controls preload="metadata">
                                <source src="{{ $bundle->video_embed_url }}">
                            </video>
                        @else
                            <iframe src="{{ $bundle->video_embed_url }}" allowfullscreen loading="lazy"></iframe>
                        @endif
                    </div>
                @endif

                <form action="{{ route('cart.store') }}" method="post" class="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="type" value="bundle">
                    <input type="hidden" name="item_id" value="{{ $bundle->id }}">

                    @include('partials.sizing-form', [
                        'sizes' => $bundle->sizes,
                        'allowCustom' => true,
                        'measurementFields' => $bundle->measurement_fields,
                    ])

                    <div class="field-group field-group--qty">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1">
                    </div>

                    <button type="submit" class="btn btn--primary btn--block">Add bundle to cart</button>
                </form>

                <details class="product-details__accordion">
                    <summary>Shipping & returns</summary>
                    <p class="body">Delivered across Pakistan in 3–7 working days. Cash on delivery or bank transfer. Each piece in a bundle is tailored to the main size or measurements you provide here.</p>
                </details>
            </div>
        </div>
    </div>
@endsection
