
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutoring_sessions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('tutor_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('subject', 255);
            $table->dateTime('scheduled_at');
            $table->unsignedSmallInteger('duration_minutes')->default(60);
            $table->text('notes')->nullable();

            // pending, confirmed, completed, cancelled
            $table->string('status', 30)->default('pending');

            $table->timestamps();

            $table->index(['student_id', 'status']);
            $table->index(['tutor_id', 'status']);
            $table->index('scheduled_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutoring_sessions');
    }
};
