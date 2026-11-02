@extends('layouts.app')

@section('title', $product->name . ' — Asian Groom')
@section('meta_description', \Illuminate\Support\Str::limit($product->description, 150))

@section('content')
    <div class="container product-page">
        <nav class="breadcrumb">
            <a href="{{ route('shop.index') }}">Shop</a> /
            <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a> /
            <span>{{ $product->name }}</span>
        </nav>

        <div class="product-page__layout">
            <div class="product-gallery">
                <div class="product-gallery__main" data-zoom-container>
                    <img src="{{ asset('storage/' . $product->images->first()?->path) }}" alt="{{ $product->name }}" id="gallery-main" data-gallery-main>
                    <span class="product-gallery__hint">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3" stroke-linecap="round"/><path d="M11 8v6M8 11h6" stroke-linecap="round"/></svg>
                        View gallery
                    </span>
                </div>
                @if ($product->images->count() > 1)
                    <div class="product-gallery__thumbs">
                        @foreach ($product->images as $image)
                            <button type="button" class="product-gallery__thumb" data-src="{{ asset('storage/' . $image->path) }}">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="product-details">
                <p class="eyebrow">{{ $product->category->name }}</p>
                <h1 class="h1">{{ $product->name }}</h1>
                <p class="product-details__price price">
                    @if ($product->is_on_sale)
                        <s>Rs {{ number_format($product->price) }}</s> Rs {{ number_format($product->sale_price) }}
                    @else
                        Rs {{ number_format($product->price) }}
                    @endif
                </p>

                <p class="body">{{ $product->description }}</p>

                @if ($product->occasions->count())
                    <div class="product-details__occasions">
                        @foreach ($product->occasions as $occasion)
                            <span class="tag">{{ $occasion->name }}</span>
                        @endforeach
                    </div>
                @endif

                @if ($product->has_video)
                    <div class="product-video">
                        @if (preg_match('/\.(mp4|mov)(\?.*)?$/i', $product->video_embed_url))
                            <video controls preload="metadata" poster="{{ asset('storage/' . $product->images->first()?->path) }}">
                                <source src="{{ $product->video_embed_url }}">
                            </video>
                        @else
                            <iframe src="{{ $product->video_embed_url }}" allowfullscreen loading="lazy"></iframe>
                        @endif
                    </div>
                @endif

                <form action="{{ route('cart.store') }}" method="post" class="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="type" value="product">
                    <input type="hidden" name="item_id" value="{{ $product->id }}">

                    @include('partials.sizing-form', [
                        'sizes' => $product->sizes,
                        'allowCustom' => $product->allow_custom_sizing,
                        'measurementFields' => $product->category->measurement_fields,
                    ])

                    <div class="field-group field-group--qty">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                    </div>

                    <button type="submit" class="btn btn--primary btn--block">Add to cart</button>
                </form>

                @if ($product->fabric_details)
                    <details class="product-details__accordion">
                        <summary>Fabric & craft</summary>
                        <p class="body">{{ $product->fabric_details }}</p>
                    </details>
                @endif

                <details class="product-details__accordion">
                    <summary>Shipping & returns</summary>
                    <p class="body">Delivered across Pakistan in 3–7 working days. Cash on delivery or bank transfer. Made-to-order pieces can be exchanged for size within 7 days of delivery.</p>
                </details>
            </div>
        </div>

        @if ($related->count())
            <section class="related-products">
                <h2 class="h2">You may also like</h2>
                <div class="shop__grid">
                    @foreach ($related as $relatedProduct)
                        @include('partials.product-card', ['product' => $relatedProduct])
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
