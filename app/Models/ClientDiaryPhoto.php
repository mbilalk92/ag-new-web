<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDiaryPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'path', 'caption', 'width', 'height', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getAspectRatioAttribute(): float
    {
        if (! $this->width || ! $this->height) {
            return 1.3;
        }

        return $this->height / $this->width;
    }
}
