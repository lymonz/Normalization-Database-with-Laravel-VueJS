<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    

    protected $primaryKey = 'id';
    protected $table = 'mahasiswas';

    protected $fillable = [
        'nim',
        'nama',
        'prodi_id',
        'no_hp',
        'alamat',
    ];

    public function prodis(){
        return $this->belongsTo(Prodi::class, "prodi_id", "id");
    }

    public function nilai(){
        return $this->hasMany(Nilai::class, "mhs_id", "id");
    }
}
