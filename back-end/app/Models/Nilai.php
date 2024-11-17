<?php

namespace App\Models;

use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nilai extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'nilais';

    protected $fillable = [
        'mhs_id',
        'matkul_id',
        'nilai',
    ];

    public function mahasiswas(){
        return $this->belongsTo(Mahasiswa::class, "mhs_id", "id");
    }

    public function matkuls(){
        return $this->belongsTo(MataKuliah::class, "matkul_id", "id");
    }

    // public function prodi(){
    //     return $this->belongsTo(Prodi::class, "prodi_id", "id");
    // }
}
