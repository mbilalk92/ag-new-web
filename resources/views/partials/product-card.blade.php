@php($image = $product->images->first())
<a href="{{ route('product.show', $product->slug) }}" class="product-card reveal">
    <div class="product-card__image" data-skeleton>
        @if ($image)
            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}" loading="lazy">
        @endif
        @if ($product->is_on_sale)
            <span class="product-card__sale">Sale</span>
        @endif
        @if ($product->has_video)
            <span class="product-card__play" aria-hidden="true">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
            </span>
        @endif
    </div>
    <div class="product-card__info">
        <p class="product-card__category">{{ $product->category->name }}</p>
        <p class="product-card__name">{{ $product->name }}</p>
        <p class="product-card__price price">
            @if ($product->is_on_sale)
                <s>Rs {{ number_format($product->price) }}</s> Rs {{ number_format($product->sale_price) }}
            @else
                Rs {{ number_format($product->price) }}
            @endif
        </p>
    </div>
</a>
