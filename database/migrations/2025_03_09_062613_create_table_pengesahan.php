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
        Schema::create('tb_lembar_pengesahan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_id');
            $table->string('nama_kegiatan');
            $table->text('sasaran');
            $table->text('program');
            $table->text('indikator_kerja');
            $table->string('peserta');
            $table->date('tanggal_pelaksanaan');
            $table->decimal('jumlah_dana', 15, 2);
            $table->string('dpk');
            $table->string('ketua_pelaksana');
            $table->string('nim_ketua_pelaksana');
            $table->timestamps();

            $table->foreign('jadwal_id')->references('id')->on('tb_jadwal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_lembar_pengesahan');
    }
};
