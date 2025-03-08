<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('tb_anggota', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama');
            $table->string('nim')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('bidang')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('kelas')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        Schema::create('tb_tempat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tempat');
            $table->string('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::create('tb_profil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama');
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('logo')->nullable();
            $table->string('kontak')->nullable();
            $table->timestamps();
        });

        Schema::create('tb_jadwal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama_kegiatan');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->enum('status_validasi', ['pending', 'valid', 'invalid'])->default('pending');
            $table->text('catatan_validasi')->nullable();
            $table->timestamps();
        });

        Schema::create('tb_jadwal_tempat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_id');
            $table->unsignedBigInteger('tempat_id');
            $table->timestamps();

            $table->foreign('jadwal_id')->references('id')->on('tb_jadwal')->onDelete('cascade');
            $table->foreign('tempat_id')->references('id')->on('tb_tempat')->onDelete('cascade');
        });

        Schema::create('tb_proposal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_id');
            $table->string('file_proposal');
            $table->date('tanggal_upload');
            $table->timestamps();
        });

        Schema::create('tb_dokumentasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->string('foto');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_dokumentasi');
        Schema::dropIfExists('tb_proposal');
        Schema::dropIfExists('tb_jadwal_tempat');
        Schema::dropIfExists('tb_jadwal');
        Schema::dropIfExists('tb_profil');
        Schema::dropIfExists('tb_tempat');
        Schema::dropIfExists('tb_anggota');
    }
};
