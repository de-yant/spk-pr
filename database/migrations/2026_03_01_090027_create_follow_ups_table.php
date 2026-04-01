<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('follow_ups', function (Blueprint $table) {

            $table->id();

            // FK ke calon konsumen
            $table->foreignId('calon_konsumen_id')
                ->constrained('calon_konsumen')
                ->cascadeOnDelete();

            $table->date('tgl_followup');

            // kategori respon (WAJIB DIISI)
            $table->unsignedTinyInteger('respon_followup')
                ->comment('1=Responsif, 2=Lambat, 3=Tidak Respon');

            $table->text('catatan_followup')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
