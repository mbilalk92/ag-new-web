<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name', 'default_meta_title', 'default_meta_description', 'default_og_image',
        'google_site_verification', 'google_analytics_id', 'meta_pixel_id', 'robots_extra',
        'home_banner_image', 'home_banner_video_file', 'home_banner_video_url',
        'home_banner_eyebrow', 'home_banner_heading', 'home_banner_subheading',
        'whatsapp_number', 'whatsapp_default_message',
    ];

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'site_name' => 'Asian Groom',
            'default_meta_title' => 'Asian Groom — Wedding Sherwanis & Groom\'s Wear',
            'default_meta_description' => 'Hand-embroidered sherwanis, kurtas, and groom\'s wear for barat, nikkah, valima, and mehndi — Asian Groom, Karachi.',
            'whatsapp_number' => '+923303900476',
            'whatsapp_default_message' => "Hi Asian Groom, I'd like to ask about...",
        ]);
    }

    public function getOgImageUrlAttribute(): ?string
    {
        return $this->default_og_image ? asset('storage/' . $this->default_og_image) : null;
    }

    public function getHomeBannerVideoEmbedUrlAttribute(): ?string
    {
        if ($this->home_banner_video_file) {
            return asset('storage/' . $this->home_banner_video_file);
        }

        return $this->home_banner_video_url;
    }

    public function getHomeBannerHasVideoAttribute(): bool
    {
        return (bool) ($this->home_banner_video_file || $this->home_banner_video_url);
    }

    public function getHomeBannerImageUrlAttribute(): ?string
    {
        return $this->home_banner_image ? asset('storage/' . $this->home_banner_image) : null;
    }

    public function getWhatsappLinkAttribute(): ?string
    {
        if (! $this->whatsapp_number) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $this->whatsapp_number);
        $url = "https://wa.me/{$digits}";

        if ($this->whatsapp_default_message) {
            $url .= '?text=' . rawurlencode($this->whatsapp_default_message);
        }

        return $url;
    }
}
