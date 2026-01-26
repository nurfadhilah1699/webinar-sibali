<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // listening, structure, reading
            $table->text('question_text');
            $table->string('audio_path')->nullable(); // khusus listening
            $table->string('a');
            $table->string('b');
            $table->string('c');
            $table->string('d');
            $table->string('correct_answer'); // A, B, C, atau D
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
