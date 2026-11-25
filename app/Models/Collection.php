<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'video_file', 'video_url',
        'is_active', 'sort_order', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
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
