@foreach ($photos as $photo)
    <div class="feed__item reveal">
        <div class="feed-card feed-card--static"
             data-skeleton
             data-lightbox-group="client-diaries"
             data-lightbox-src="{{ asset('storage/' . $photo->path) }}"
             data-lightbox-alt="{{ $photo->caption ?? 'Asian Groom client' }}">
            <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->caption ?? 'Asian Groom client' }}" loading="lazy" width="{{ $photo->width }}" height="{{ $photo->height }}">
            <button type="button" class="feed-card__shop-look" data-shop-look data-photo-id="{{ $photo->id }}" data-photo-src="{{ asset('storage/' . $photo->path) }}">
                Shop the look
            </button>
            @if ($photo->caption)
                <span class="feed-card__overlay">
                    <span class="feed-card__name">{{ $photo->caption }}</span>
                </span>
            @endif
        </div>
    </div>
@endforeach
