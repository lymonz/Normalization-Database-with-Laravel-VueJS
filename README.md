# Normalization-Database-with-Laravel-VueJS

# Introduction
Repositori ini merupakan mini projek yang saya buat berdasarkan instruksi yang telah diberikan.

# Normalization Database
Normalisasi database salah satu teknik untuk mengorganisasi data kedalam tabel-tabel untuk memenuhi kebutuhan pengguna yang berarti data akan dibagi menjadi beberapa tabel yang dihubungkan dengan relationship. Selain itu normalisasi data juga memiliki tujuan untuk mengurangi duplikasi data, memudahkan dalam memaintenance data apabila ada penambahan, pengurangan dan pembaruan data.
Agar relationship bisa dilakukan dengan cara menggunakan primary keys, foreign keys dan composite key.
Dalam proses normalisasi data ada beberapa tahapan yaitu 1NF, 2NF dan 3NF.

# Example

## Tabel
Ini merupakan tabel yang menyimpan penilaian data mahasiswa dan matakuliah yang diambil. Ada duplikasi data pada tabel dibawah ini yaitu pada informasi mahasiswa (nama dan program studi)
<table>
  <thead>
    <tr>
      <th>Nim</th>
      <th>Nama</th>
      <th>Program Studi</th>
      <th>Kode Matkul</th>
      <th>Mata Kuliah</th>
      <th>Dosen Pengampu</th>
      <th>Nilai</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1001</td>
      <td>Roni</td>
      <td>Teknik Komputer</td>
      <td>K-001</td>
      <td>Pemrograman Web</td>
      <td>Juliansyah</td>
      <td>B</td>
    </tr>
    <tr>
      <td>1002</td>
      <td>Rino</td>
      <td>Teknik Informatika</td>
      <td>K-002</td>
      <td>Arsitektur Data</td>
      <td>Yoppy</td>
      <td>A</td>
    </tr>
    <tr>
      <td>1001</td>
      <td>Roni</td>
      <td>Teknik Komputer</td>
      <td>K-003</td>
      <td>Komputasi Bergerak</td>
      <td>Sarmayanta</td>
      <td>A</td>
    </tr>
    <tr>
      <td>1003</td>
      <td>Indah</td>
      <td>Komputerisasi Akuntansi</td>
      <td>K-004</td>
      <td>Basis Data</td>
      <td>Rivai</td>
      <td>A</td>
    </tr>
    <tr>
      <td>1004</td>
      <td>Rian</td>
      <td>Teknik Komputer</td>
      <td>K-001</td>
      <td>Pemrograman Web</td>
      <td>Juliansyah</td>
      <td>A</td>
    </tr>
  </tbody>
</table>


