<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('jadwal_id');
            $table->string('kegiatan_singkat'); // LKMM-TD
            $table->text('kegiatan_lengkap'); // Full title
            $table->string('nama_penyusun');
            $table->string('nim_penyusun');
            $table->text('nama_institusi');
            $table->year('tahun');

            // I. LATAR BELAKANG
            $table->json('dasar_kegiatan'); // Array of legal basis
            $table->longText('gambaran_umum');

            // II. PENERIMA MANFAAT
            $table->longText('penerima_manfaat');

            // III. STRATEGI PENCAPAIAN KELUARAN
            $table->json('metode_pelaksanaan'); // Array of methods
            $table->json('tahapan_pelaksanaan'); // Array of stages
            $table->text('deskripsi_waktu_pelaksanaan');
            $table->json('bulan_headers'); // Array of months
            $table->json('jadwal_kegiatan'); // Array of activities with timeline
            $table->text('kurun_waktu_pencapaian');
            $table->text('deskripsi_materi_kegiatan');
            $table->json('materi_kegiatan'); // Array of materials with speakers
            $table->string('hari_tanggal_acara'); // Day and date
            $table->json('susunan_acara'); // Array of agenda items

            // IV. BIAYA YANG DIPERLUKAN
            $table->text('deskripsi_biaya');
            $table->string('judul_anggaran'); // Title for budget table
            $table->json('anggaran_belanja'); // Array of budget items
            $table->decimal('total_anggaran', 15, 2);
            $table->string('judul_kepanitiaan'); // Title for committee table
            $table->json('susunan_kepanitiaan'); // Array of committee members

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
