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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Contoh: "Webinar Karir Ep 1" [cite: 139]
            $table->string('slug')->unique();
            $table->enum('type', ['webinar', 'lcc', 'toefl']); 
            $table->unsignedBigInteger('parent_id')->nullable(); // Untuk mengelompokkan Series [cite: 143]
            $table->dateTime('start_time'); // Waktu mulai untuk Whitelist [cite: 2]
            $table->integer('duration')->default(0); // LCC 45 menit [cite: 2]
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
