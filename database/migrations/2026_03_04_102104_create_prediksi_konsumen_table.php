<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prediksi_konsumen', function (Blueprint $table) {
            $table->bigIncrements('id_prediksi');

            $table->unsignedInteger('id_calon_konsumen'); // FK ke calon_konsumen

            $table->string('tahap_prediksi', 10); // Awal / Ke-2 / Akhir
            $table->string('keputusan_pembelian', 20);
            $table->decimal('nilai_probabilitas', 6, 4); // contoh 0.8421
            $table->dateTime('tgl_prediksi');

            $table->timestamps();

            $table->foreign('id_calon_konsumen')
                ->references('id_calon_konsumen')
                ->on('calon_konsumen')
                ->onDelete('cascade');

            // Supaya 1 calon cuma punya 1 hasil per tahap (Awal/Ke-2/Akhir)
            $table->unique(['id_calon_konsumen', 'tahap_prediksi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prediksi_konsumen');
    }
};
