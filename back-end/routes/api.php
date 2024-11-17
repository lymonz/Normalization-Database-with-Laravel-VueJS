<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\ProdiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'],function ($router) {

    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('me', [AuthController::class, 'me'])->name('me');
    
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'index'], function () {
    // Rute untuk Mahasiswa
    Route::get('mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index'); 
    Route::get('mahasiswa/{id}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
    Route::get('mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create'); 
    Route::get('mahasiswa/edit/{id}', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit'); 
    Route::post('mahasiswa/store', [MahasiswaController::class, 'store'])->name("mahasiswa.store"); 
    Route::put('mahasiswa/update/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update'); 
    Route::delete('mahasiswa/destroy/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy'); 
    // Rute untuk Prodi
    Route::get('prodi', [ProdiController::class, 'index'])->name('prodi.index'); 
    Route::get('prodi/{id}', [ProdiController::class, 'show'])->name('prodi.show'); 
    Route::get('prodi/edit/{id}', [ProdiController::class, 'edit'])->name('prodi.edit'); 
    Route::post('prodi/store', [ProdiController::class, 'store'])->name("prodi.store"); 
    Route::put('prodi/update/{id}', [ProdiController::class, 'update'])->name('prodi.update'); 
    Route::delete('prodi/destroy/{id}', [ProdiController::class, 'destroy'])->name('prodi.destroy'); 

    // MAtakuliah
    Route::get('matkul', [MataKuliahController::class, 'index'])->name('matkul.index'); 
    Route::get('matkul/{id}', [MataKuliahController::class, 'show'])->name('matkul.show'); 
    Route::get('matkul/edit/{id}', [MataKuliahController::class, 'edit'])->name('matkul.edit'); 
    Route::post('matkul/store', [MataKuliahController::class, 'store'])->name("matkul.store"); 
    Route::put('matkul/update/{id}', [MataKuliahController::class, 'update'])->name('matkul.update'); 
    Route::delete('matkul/destroy/{id}', [MataKuliahController::class, 'destroy'])->name('matkul.destroy'); 

    // Nilai
    Route::get('nilai', [NilaiController::class, 'index'])->name('nilai.index'); 
    Route::get('nilai/{id}', [NilaiController::class, 'show'])->name('nilai.show'); 
    Route::get('nilai/edit/{id}', [NilaiController::class, 'edit'])->name('nilai.edit'); 
    Route::post('nilai/store', [NilaiController::class, 'store'])->name("nilai.store"); 
    Route::put('nilai/update/{id}', [NilaiController::class, 'update'])->name('nilai.update'); 
    Route::delete('nilai/destroy/{id}', [NilaiController::class, 'destroy'])->name('nilai.destroy'); 
});