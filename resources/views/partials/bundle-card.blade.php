@php($image = $bundle->images->first())
<a href="{{ route('bundle.show', $bundle->slug) }}" class="product-card">
    <div class="product-card__image">
        @if ($image)
            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $bundle->name }}" loading="lazy">
        @endif
        <span class="product-card__sale">Bundle</span>
    </div>
    <div class="product-card__info">
        <p class="product-card__category">{{ count($bundle->included_items ?? []) }} pieces</p>
        <p class="product-card__name">{{ $bundle->name }}</p>
        <p class="product-card__price price">
            @if ($bundle->is_on_sale)
                <s>Rs {{ number_format($bundle->compare_at_price) }}</s> Rs {{ number_format($bundle->price) }}
            @else
                Rs {{ number_format($bundle->price) }}
            @endif
        </p>
    </div>
</a>
