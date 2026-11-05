<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    const MEASUREMENT_FIELDS = [
        'top' => [
            'collar' => 'Collar',
            'chest' => 'Chest',
            'waist' => 'Waist',
            'body_length' => 'Body length',
            'arm_length' => 'Arm length',
            'arm_hole_width' => 'Arm hole width',
            'bust' => 'Bust',
            'height' => 'Height of person',
        ],
        'trouser' => [
            'trouser_waist' => 'Waist',
            'trouser_length' => 'Length',
            'foot_hole_width' => 'Foot hole width',
        ],
    ];

    protected $fillable = [
        'name', 'slug', 'image', 'description', 'sort_order', 'measurement_type',
        'meta_title', 'meta_description',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getMeasurementFieldsAttribute(): array
    {
        return match ($this->measurement_type) {
            'top' => self::MEASUREMENT_FIELDS['top'],
            'trouser' => self::MEASUREMENT_FIELDS['trouser'],
            'top_trouser' => self::MEASUREMENT_FIELDS['top'] + self::MEASUREMENT_FIELDS['trouser'],
            default => [],
        };
    }
}
