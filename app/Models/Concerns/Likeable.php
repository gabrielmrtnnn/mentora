<?php

namespace App\Models\Concerns;

use App\Models\ForumLike;

trait Likeable
{
    public function likes()
    {
        return $this->morphMany(ForumLike::class, 'likeable');
    }

    /**
     * Cek apakah user tertentu sudah nge-like record ini.
     * Kalau relasi 'likes' udah di-eager-load, dicek dari collection
     * (hindari N+1), kalau belum baru query langsung.
     */
    public function isLikedBy(?int $userId): bool
    {
        if (! $userId) {
            return false;
        }

        if ($this->relationLoaded('likes')) {
            return $this->likes->contains('user_id', $userId);
        }

        return $this->likes()->where('user_id', $userId)->exists();
    }

    /**
     * Jumlah like. Pakai hasil withCount('likes') kalau ada,
     * fallback ke relasi yang udah di-load, fallback lagi ke query.
     */
    public function getLikesCountAttribute(): int
    {
        if (array_key_exists('likes_count', $this->attributes)) {
            return (int) $this->attributes['likes_count'];
        }

        if ($this->relationLoaded('likes')) {
            return $this->likes->count();
        }

        return $this->likes()->count();
    }

    /**
     * Kalau thread/reply-nya dihapus, like yang nempel ikut dihapus.
     * Perlu manual karena relasi polymorphic gak bisa dikasih FK cascade di DB.
     */
    protected static function bootLikeable(): void
    {
        static::deleting(function ($model) {
            $model->likes()->delete();
        });
    }
}
