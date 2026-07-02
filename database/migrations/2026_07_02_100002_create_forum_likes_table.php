<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel polymorphic tunggal biar satu mekanisme "like" bisa dipakai
     * buat like thread (forum_threads) maupun like balasan (forum_replies).
     */
    public function up(): void
    {
        Schema::create('forum_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('likeable'); // likeable_id + likeable_type
            $table->timestamps();

            // Satu user cuma bisa like satu kali per thread/balasan
            $table->unique(['user_id', 'likeable_id', 'likeable_type'], 'forum_likes_unique_like');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forum_likes');
    }
};
