<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudyGroup extends Model
{
    protected $fillable = ['name', 'subject', 'slug', 'created_by'];
    /**
     * Relasi ke User (Siapa yang bikin room ini)
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function visits()
    {
        return $this->hasMany(StudyRoomVisit::class);
    }
}