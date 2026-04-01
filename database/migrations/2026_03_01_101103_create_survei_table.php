<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('survei', function (Blueprint $table) {
            $table->increments('id_survei');

            $table->unsignedInteger('calon_konsumen_id')->index(); // FK ke calon_konsumen.id

            $table->tinyInteger('survei'); // 1=Ya, 2=Tidak
            $table->date('tgl_survei');
            $table->string('hasil_survei', 30);
            $table->text('catatan_survei')->nullable();

            $table->timestamps();

            $table->foreign('calon_konsumen_id')
                ->references('id')->on('calon_konsumen')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survei');
    }
};
