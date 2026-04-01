<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('training', function (Blueprint $table) {

            $table->string('id')->primary();

            $table->string('nama');
            $table->string('no_hp');

            // DATA RUMAH
            $table->integer('harga');
            $table->string('tipe');
            $table->integer('lokasi'); // 1-4 (strategis dll)

            // DATA KREDIT
            $table->integer('bi'); // 1=lolos 2=tidak lolos
            $table->integer('cicilan');
            $table->integer('dp');

            // DATA DEMOGRAFI
            $table->integer('usia');
            $table->integer('penghasilan');
            $table->string('pekerjaan');

            $table->integer('status_nikah'); // 1-4
            $table->integer('tanggungan');

            // PERILAKU
            $table->integer('metode'); // 1=kpr 2=cash bertahap 3=cash keras
            $table->integer('kunjungan');
            $table->integer('respon'); // 1 responsif 2 lambat 3 tidak respon

            // SURVEI
            $table->tinyInteger('survei'); // 1 ya 0 tidak

            // TARGET NAIVE BAYES
            $table->tinyInteger('keputusan'); // 1 membeli 0 tidak membeli

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training');
    }
};
