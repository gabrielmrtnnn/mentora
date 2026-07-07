<?php

namespace App\Models\Concerns;

use App\Models\ForumReport;

trait Reportable
{
    public function reports()
    {
        return $this->morphMany(ForumReport::class, 'reportable');
    }

    /**
     * Cek apakah user tertentu udah pernah report record ini.
     * Dipakai buat sembunyiin tombol "Report" kalau udah pernah lapor.
     */
    public function isReportedBy(?int $userId): bool
    {
        if (! $userId) {
            return false;
        }

        return $this->reports()->where('user_id', $userId)->exists();
    }

    /**
     * Kalau thread/reply-nya dihapus, report yang nempel ikut dihapus
     * biar gak ada report "hantu" yang nunjuk ke konten yang udah gak ada.
     */
    protected static function bootReportable(): void
    {
        static::deleting(function ($model) {
            $model->reports()->delete();
        });
    }
}
