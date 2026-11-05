<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'description', 'fabric_details',
        'price', 'sale_price', 'sizes', 'stock', 'video_file', 'video_url',
        'allow_custom_sizing', 'is_featured', 'is_active',
        'meta_title', 'meta_description',
    ];

    protected $casts = [
        'sizes' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'allow_custom_sizing' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function occasions(): BelongsToMany
    {
        return $this->belongsToMany(Occasion::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getDisplayPriceAttribute(): int
    {
        return $this->sale_price ?? $this->price;
    }

    public function getIsOnSaleAttribute(): bool
    {
        return ! is_null($this->sale_price) && $this->sale_price < $this->price;
    }

    public function getPrimaryImageAttribute(): ?ProductImage
    {
        return $this->images->first();
    }

    public function getVideoEmbedUrlAttribute(): ?string
    {
        if ($this->video_file) {
            return asset('storage/' . $this->video_file);
        }

        return $this->video_url;
    }

    public function getHasVideoAttribute(): bool
    {
        return (bool) ($this->video_file || $this->video_url);
    }
}
