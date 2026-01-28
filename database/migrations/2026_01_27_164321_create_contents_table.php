<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Contoh: "Link Grup WhatsApp VIP 1" atau "Materi Strategi TOEFL"
            $table->enum('type', ['materi', 'rekaman', 'link_wa', 'link_zoom']); // Jenis konten
            $table->text('link'); // URL tujuan
            $table->enum('package', ['reguler', 'vip1', 'vip2']); // Siapa yang bisa lihat?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
