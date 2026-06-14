<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{

    public $timestamps = false;

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'action',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}