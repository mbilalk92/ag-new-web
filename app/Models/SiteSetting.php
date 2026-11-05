<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name', 'default_meta_title', 'default_meta_description', 'default_og_image',
        'google_site_verification', 'google_analytics_id', 'meta_pixel_id', 'robots_extra',
    ];

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'site_name' => 'Asian Groom',
            'default_meta_title' => 'Asian Groom — Wedding Sherwanis & Groom\'s Wear',
            'default_meta_description' => 'Hand-embroidered sherwanis, kurtas, and groom\'s wear for barat, nikkah, valima, and mehndi — Asian Groom, Karachi.',
        ]);
    }

    public function getOgImageUrlAttribute(): ?string
    {
        return $this->default_og_image ? asset('storage/' . $this->default_og_image) : null;
    }
}
