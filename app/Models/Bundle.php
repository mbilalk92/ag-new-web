<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'included_items', 'sizes', 'measurement_type',
        'price', 'compare_at_price', 'video_file', 'video_url',
        'is_featured', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'included_items' => 'array',
        'sizes' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(BundleImage::class)->orderBy('sort_order');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getVideoEmbedUrlAttribute(): ?string
    {
        if ($this->video_file) {
            return asset('storage/' . $this->video_file);
        }

        return $this->video_url;
    }

    public function getIsOnSaleAttribute(): bool
    {
        return ! is_null($this->compare_at_price) && $this->compare_at_price > $this->price;
    }

    public function getMeasurementFieldsAttribute(): array
    {
        return match ($this->measurement_type) {
            'top' => Category::MEASUREMENT_FIELDS['top'],
            'trouser' => Category::MEASUREMENT_FIELDS['trouser'],
            'top_trouser' => Category::MEASUREMENT_FIELDS['top'] + Category::MEASUREMENT_FIELDS['trouser'],
            default => [],
        };
    }
}
