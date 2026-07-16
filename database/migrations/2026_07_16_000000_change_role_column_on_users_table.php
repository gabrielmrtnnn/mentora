<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Kolom `role` di beberapa environment lokal masih berupa ENUM lama
     * ('admin', 'tutor', 'user'), sisa dari sebelum aplikasi pindah pakai
     * istilah 'student'. Migration ini mengubah kolom jadi VARCHAR biasa
     * (sesuai definisi terbaru di create_users_table) dan memigrasikan
     * akun lama yang masih berrole 'user' menjadi 'student'.
     */
    public function up(): void
    {
        // Ubah tipe kolom dari ENUM ke VARCHAR agar bisa menampung role apapun,
        // termasuk 'student' yang tidak ada di ENUM lama.
        DB::statement("ALTER TABLE users MODIFY role VARCHAR(255) NOT NULL DEFAULT 'student'");

        // Migrasikan data lama: role 'user' -> 'student'
        DB::table('users')->where('role', 'user')->update(['role' => 'student']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan data 'student' -> 'user' sebelum mengembalikan tipe kolom ke ENUM
        DB::table('users')->where('role', 'student')->update(['role' => 'user']);

        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','tutor','user') NOT NULL DEFAULT 'user'");
    }
};
