<?php

namespace App\Models;

use App\Models\Concerns\Likeable;
use App\Models\Concerns\Reportable;
use Illuminate\Database\Eloquent\Model;

class ForumThread extends Model
{
    use Likeable, Reportable;

    protected $fillable = [
        'user_id',
        'category',
        'title',
        'body',
    ];

    /**
     * Kategori yang boleh dipilih user pas bikin diskusi baru,
     * lengkap sama label tampilan & warna badge-nya.
     * 'pengumuman' sengaja gak masuk sini (khusus admin/seed).
     */
    public const CREATABLE_CATEGORIES = [
        'diskusi umum' => ['label' => 'Diskusi Umum', 'color' => 'bg-blue-100 text-blue-600'],
        'tanya jawab' => ['label' => 'Tanya Jawab', 'color' => 'bg-purple-100 text-purple-600'],
    ];

    public const CATEGORIES = self::CREATABLE_CATEGORIES + [
        'pengumuman' => ['label' => 'Pengumuman', 'color' => 'bg-amber-100 text-amber-600'],
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(ForumReply::class)->oldest();
    }

    public function images()
    {
        return $this->hasMany(ForumThreadImage::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category]['label'] ?? ucwords($this->category);
    }

    public function getCategoryColorAttribute(): string
    {
        return self::CATEGORIES[$this->category]['color'] ?? 'bg-gray-100 text-gray-600';
    }

    /**
     * Hapus reply satu-satu (bukan cuma andalin DB cascade) supaya event
     * 'deleting' punya reply (buat bersihin like & report-nya) ikut jalan.
     * File gambar thread juga dihapus dari storage, gak cuma row-nya.
     */
    protected static function booted(): void
    {
        static::deleting(function (ForumThread $thread) {
            $thread->replies->each(fn (ForumReply $reply) => $reply->delete());

            $thread->images->each(function (ForumThreadImage $image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($image->path);
                $image->delete();
            });
        });
    }
}
