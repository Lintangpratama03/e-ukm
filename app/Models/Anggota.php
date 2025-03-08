<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'tb_anggota';
    protected $fillable = ['user_id', 'nama', 'nim', 'jabatan', 'no_hp', 'jurusan', 'kelas', 'foto'];
}
