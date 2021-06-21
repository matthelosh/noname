<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelajaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_pembelajaran','label','periode_id','rombel_id','guru_id','is_tematik','tema_id','subtema_id','rpp','materi','video','tanggal','keterangan','active'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'nip');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id', 'kode_periode');
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id', 'kode_rombel');
    }

    public function tema()
    {
        return $this->belongsTo(Tema::class, 'tema_id', 'kode_tema');
    }

    public function subtema()
    {
        return $this->belongsTo(Subtema::class, 'subtema_id', 'kode_subtema');
    }

    public function penilaian()
    {
        return $this->hasMany(penilaian::class, 'pembelajaran_id', 'kode_pembelajaran');
    }

}
