<?php

namespace App\Models;

use App\Models\Scopes\AvailableForUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new AvailableForUser());
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage(): Model|HasMany|null
    {
        return $this->messages()->latest()->first();
    }

    public function scopeAvailableForUser(Builder $builder, User $user): void
    {
        $builder->where('user_id', $user->id)
            ->orWhereHas('users', function (Builder $query) use ($user) {
                $query->where('user_id', $user->id);
            });
    }
}
