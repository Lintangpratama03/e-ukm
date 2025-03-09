<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbLembarPengesahan extends Model
{
    use HasFactory;

    protected $table = 'tb_lembar_pengesahan';

    protected $fillable = [
        'jadwal_id',
        'nama_kegiatan',
        'sasaran',
        'program',
        'indikator_kerja',
        'peserta',
        'tanggal_pelaksanaan',
        'jumlah_dana',
        'sumber_dana',
        'dpk',
        'ketua_pelaksana',
        'nim_ketua_pelaksana',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }
}
