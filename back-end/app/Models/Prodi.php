<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodis';

    protected $fillable = [
        'prodi',
        'jurusan',
    ];
    
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, "prodi_id", "id");
    }

    public function nilai()
    {
        return $this->hasMany(Mahasiswa::class, "prodi_id", "id");
    }

    
}
