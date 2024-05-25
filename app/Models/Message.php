<?php

namespace App\Models;

use App\Casts\DateFormatter;
use App\Models\Scopes\AvailableForUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'user_id',
        'chat_id',
        'body',
    ];

    protected $casts = [
        'created_at' => DateFormatter::class,
        'updated_at' => DateFormatter::class,
    ];

    protected static function booted()
    {
        static::addGlobalScope(new AvailableForUser());
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function scopeAvailableForUser(Builder $builder, User $user)
    {
        $builder->whereHas('chat');
    }
}
