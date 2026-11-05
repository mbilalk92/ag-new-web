<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LookInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_diary_photo_id', 'name', 'email', 'phone', 'city',
        'sizing_mode', 'size', 'measurements', 'message', 'status',
    ];

    protected $casts = [
        'measurements' => 'array',
    ];

    public function photo(): BelongsTo
    {
        return $this->belongsTo(ClientDiaryPhoto::class, 'client_diary_photo_id');
    }
}
