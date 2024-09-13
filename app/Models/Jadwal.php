<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $primaryKey = "id_jadwal";
    protected $table = "jadwal";
    protected $fillable = [
        'id_user',
        'nama_dokter',
        'waktu_check',
        'pengulangan',
        'waktu',
        'waktu_pengingat',
    ];
}
