<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel polymorphic tunggal, sama pola-nya kayak forum_likes,
     * biar satu mekanisme "report" bisa dipakai buat report thread
     * (forum_threads) maupun report balasan (forum_replies).
     */
    public function up(): void
    {
        Schema::create('forum_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // yang melapor
            $table->morphs('reportable'); // reportable_id + reportable_type
            $table->string('reason');
            $table->text('description')->nullable();
            $table->timestamps();

            // Satu user cuma bisa report satu kali per thread/balasan yang sama
            $table->unique(['user_id', 'reportable_id', 'reportable_type'], 'forum_reports_unique_report');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forum_reports');
    }
};
