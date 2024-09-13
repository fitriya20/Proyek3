<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alarm extends Model
{
    use HasFactory;

    protected $primaryKey = "id_alarm";
    protected $table = "alarm";
    protected $fillable = [
        'id_user',
        'id_obat',
        'dosis',
        'waktu',
        'aturan_tambahan',
        'aturan',
        'kode_alarm'
    ];
}
