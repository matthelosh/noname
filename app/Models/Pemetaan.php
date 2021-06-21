<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemetaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_id','tema_id','subtema_id','mapel_id','kd_id','semester'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'kode_kelas');
    }

    public function tema()
    {
        return $this->belongsTo(Tema::class, 'tema_id', 'kode_tema');
    }

    public function subtema()
    {
        return $this->belongsTo(Subtema::class, 'subtema_id', 'kode_subtema');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id', 'kode_mapel');
    }

    
}
