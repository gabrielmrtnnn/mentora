<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_sessions', function (Blueprint $table) {

            $table->id();

            // siapa yang booking
            $table->foreignId('student_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // tutor yang dipilih
            $table->foreignId('tutor_id')
                ->constrained('tutors')
                ->cascadeOnDelete();

            // tanggal booking
            $table->date('session_date');

            // jam booking
            $table->time('session_time');

            // durasi (menit)
            $table->integer('duration')->default(60);

            // catatan dari student
            $table->text('note')->nullable();

            // link meeting nanti
            $table->string('meeting_room')->nullable();

            // status booking
            $table->enum('status',[
                'pending',
                'approved',
                'completed',
                'cancelled',
                'rejected'
            ])->default('pending');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_sessions');
    }
};