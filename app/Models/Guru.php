<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $fillable = [ 'nip', 'name', 'email', 'hp', 'jk', 'role', 'status', 'active', 'alamat' ];

    public function users()
    {
        return $this->morphMany('App\Models\User', 'userable');
    }
    public function rombel()
    {
        return $this->hasOne('App\Models\Rombel', 'guru_id','nip');
    }
}
