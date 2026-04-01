<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('calon_konsumen', function (Blueprint $table) {

            // SAMA seperti training
            $table->id();

            $table->string('nama');
            $table->string('no_hp');

            // DATA RUMAH
            $table->integer('harga');
            $table->string('tipe');
            $table->integer('lokasi'); // 1-4

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

            // PERILAKU (tanpa respon)
            $table->integer('metode'); // 1=kpr 2=cash bertahap 3=cash keras
            $table->integer('kunjungan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calon_konsumen');
    }
};
