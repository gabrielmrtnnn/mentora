<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumReport extends Model
{
    /**
     * Daftar alasan report yang boleh dipilih user.
     * Dipisah dari 'description' (opsional) yang isinya penjelasan bebas.
     */
    public const REASONS = [
        'spam' => 'Spam / promosi',
        'sara' => 'SARA / ujaran kebencian',
        'pelecehan' => 'Pelecehan / bullying',
        'konten tidak pantas' => 'Konten tidak pantas',
        'lainnya' => 'Lainnya',
    ];

    protected $fillable = [
        'user_id',
        'reportable_id',
        'reportable_type',
        'reason',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reportable()
    {
        return $this->morphTo();
    }

    public function getReasonLabelAttribute(): string
    {
        return self::REASONS[$this->reason] ?? ucfirst($this->reason);
    }
}
