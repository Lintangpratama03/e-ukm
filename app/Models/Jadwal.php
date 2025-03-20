<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'tb_jadwal';

    protected $fillable = [
        'user_id',
        'nama_kegiatan',
        'proposal',
        'lembar_pengesahan',
        'status_ttd',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_validasi',
        'catatan_validasi'
    ];

    public function tempats()
    {
        return $this->belongsToMany(Tempat::class, 'tb_jadwal_tempat', 'jadwal_id', 'tempat_id');
    }
    public function pengesahan()
    {
        return $this->belongsTo(TbLembarPengesahan::class, 'id', 'jadwal_id');
    }
    public function dokumentasi()
    {
        return $this->hasMany(Dokumentasi::class, 'jadwal_id');
    }
    public function ukm()
    {
        return $this->belongsTo(Profil::class, 'user_id', 'user_id');
    }
}
