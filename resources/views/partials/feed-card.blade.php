@php($image = $product->images->first())
<a href="{{ route('product.show', $product->slug) }}" class="feed-card" data-skeleton>
    @if ($image)
        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}" loading="lazy" width="{{ $image->width }}" height="{{ $image->height }}">
    @endif
    <span class="feed-card__overlay">
        <span class="feed-card__name">{{ $product->name }}</span>
        <span class="feed-card__price price">
            @if ($product->is_on_sale)
                <s>Rs {{ number_format($product->price) }}</s> Rs {{ number_format($product->sale_price) }}
            @else
                Rs {{ number_format($product->price) }}
            @endif
        </span>
    </span>
    @if ($product->is_featured)
        <span class="feed-card__badge">Featured</span>
    @endif
    @if ($product->has_video)
        <span class="feed-card__play" aria-hidden="true">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
        </span>
    @endif
</a>
