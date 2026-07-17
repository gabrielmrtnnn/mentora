<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Kolom `read_at` ditambahkan langsung ke migration
     * `create_messages_table` yang lama (bukan migration baru), jadi
     * environment yang tabel `messages`-nya sudah lebih dulu ada tidak
     * ikut mendapat kolom ini saat `php artisan migrate`. Migration ini
     * menambahkan kolomnya jika belum ada, supaya semua environment
     * (lama maupun baru) konsisten.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('messages', 'read_at')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->timestamp('read_at')->nullable()->after('sender_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('messages', 'read_at')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropColumn('read_at');
            });
        }
    }
};
