<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwal_id',
        'kegiatan_singkat',
        'kegiatan_lengkap',
        'nama_penyusun',
        'nim_penyusun',
        'nama_institusi',
        'tahun',
        'dasar_kegiatan',
        'gambaran_umum',
        'penerima_manfaat',
        'metode_pelaksanaan',
        'tahapan_pelaksanaan',
        'deskripsi_waktu_pelaksanaan',
        'bulan_headers',
        'jadwal_kegiatan',
        'kurun_waktu_pencapaian',
        'deskripsi_materi_kegiatan',
        'materi_kegiatan',
        'hari_tanggal_acara',
        'susunan_acara',
        'deskripsi_biaya',
        'judul_anggaran',
        'anggaran_belanja',
        'total_anggaran',
        'judul_kepanitiaan',
        'susunan_kepanitiaan',
        'daftar_alat',
        'judul_alat'
    ];

    protected $casts = [
        'program_list' => 'array',
        'dasar_kegiatan' => 'array',
        'metode_pelaksanaan' => 'array',
        'tahapan_pelaksanaan' => 'array',
        'bulan_headers' => 'array',
        'jadwal_kegiatan' => 'array',
        'materi_kegiatan' => 'array',
        'susunan_acara' => 'array',
        'anggaran_belanja' => 'array',
        'susunan_kepanitiaan' => 'array',
        'daftar_alat' => 'array',
        'jumlah_dana' => 'decimal:2',
        'total_anggaran' => 'decimal:2',
    ];


    protected function totalAnggaranFormat(): Attribute
    {
        return Attribute::make(
            get: fn() => 'Rp' . number_format($this->total_anggaran, 0, ',', '.')
        );
    }
}
