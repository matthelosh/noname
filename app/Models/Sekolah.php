<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;
    protected $fillable = [
        'npsn','nama_sekolah','alamat','desa','kec','kab','prov','kode_pos','telp','email','website','ks','operator'
    ];

    public function ks()
    {
        return $this->hasOne('App\Models\Guru', 'nip', 'ks');
    }
    public function ops()
    {
        return $this->belongsTo('App\Models\Guru', 'operator','nip');
    }
}
