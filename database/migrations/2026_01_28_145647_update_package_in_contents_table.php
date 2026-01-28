<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            // Mengubah enum dengan menambahkan 'all'
            $table->enum('package', ['reguler', 'vip1', 'vip2', 'all'])->change();
        });
    }

    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            // Kembalikan ke struktur awal jika di-rollback
            $table->enum('package', ['reguler', 'vip1', 'vip2'])->change();
        });
    }
};
