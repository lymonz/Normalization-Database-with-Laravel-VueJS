<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'mata_kuliahs';

    protected $fillable = [
        'kode_matkul',
        'mata_kuliah',
        'sks',
    ];

    public function nilai(){
        return $this->hasMany(Nilai::class, "matkul_id", "id");
    }
}
