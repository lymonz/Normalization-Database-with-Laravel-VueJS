# Normalization-Database-with-Laravel-VueJS

# Introduction
Repositori ini merupakan mini projek yang saya buat berdasarkan instruksi yang telah diberikan.

# Normalization Database
Normalisasi database salah satu teknik untuk mengorganisasi data kedalam tabel-tabel untuk memenuhi kebutuhan pengguna yang berarti data akan dibagi menjadi beberapa tabel yang dihubungkan dengan relationship. Selain itu normalisasi data juga memiliki tujuan untuk mengurangi duplikasi data, memudahkan dalam memaintenance data apabila ada penambahan, pengurangan dan pembaruan data.
Agar relationship bisa dilakukan dengan cara menggunakan primary keys, foreign keys dan composite key.
Dalam proses normalisasi data ada beberapa tahapan yaitu 1NF, 2NF dan 3NF.

# Example

## Tabel
Ini merupakan tabel yang menyimpan penilaian data mahasiswa dan matakuliah yang diambil. Ada duplikasi data pada tabel dibawah ini, untuk melakukan perubahan data dilakukan pada banyak baris, banyak data yang disimpan berulang kali, namun data ini sudah masuk ke dalam bentuk **1NF** karena setiap kolom memiliki nilai tunggal untuk setiap barisnya.

## 1NF
|Nim|Nama|Program Studi|Jurusan|Kode Matkul|Mata Kuliah|SKS|Nilai|
|-|-|-|-|-|-|-|-|
|1001|Roni|Teknik Komputer|Sistem Komputer|K-001|Pemrograman Web|3|B|
|1002|Rino|Teknik Informatika|Teknik Informatika|K-002|Arsitektur Data|2|A|
|1001|Roni|Teknik Komputer|Sistem Komputer|K-003|Komputasi Bergerak|4|A|
|1003|Indah|Komputerisasi Akuntansi|Sistem Informasi|K-004|Basis Data|3|A|
|1004|Rian|Teknik Komputer|Sistem Komputer|K-001|Pemrograman Web|3|A|

## 2NF
Selanjutnya memisahkan data yang memiliki ketergantungan parsial dimana atribut non-primer bergantung pada bagian dari primary key. pada konteks ini adalah kolom Jurusan, Mata Kuliah, SKS.
Untuk memenuhi bentuk 2 NF, tabel akan dipecah menjadi beberapa tabel untuk menghilangkan ketergantungan parsial.

**Tabel Mahasiswa**
| Nim | Nama | Program Studi | Jurusan |
| - | - | - | - |
| 1001 | Roni | Teknik Komputer | Sistem Komputer|
| 1002 | Rino | Teknik Informatika | Teknik Informatika |
| 1003 | Indah| Komputerisasi Akuntansi | Sistem Informasi|
| 1004 | Rian | Teknik Komputer | Sistem Komputer |

---
**Tabel Mata Kuliah**
|Kode Matkul|Mata Kuliah|SKS|
|-|-|-|
|K-001|Pemrograman Web|3|
|K-002|Arsitektur Data |2|
|K-003|Komputasi Bergerak|4|
|K-004|Basis Data|3|

---
**Tabel Nilai (Tabel Mahasiswa - Mata Kuliah)**
|Nim|Kode Matkul|Nilai|
|-|-|-|
|1001|K-001|B|
|1002|K-002|A|
|1001|K-003|A|
|1003|K-004|A|
|1004|K-001|A|

## 3NF
Dikarenakan adanya anomali pada insert data yaitu pada bagian program studi, apabila ada penambahan prodi baru ditambahkan maka data mahasiswa akan null itu tidak bisa terjadi dikarenakan prodi menentukan jurusan, itu dinamakan transitive dependency. untuk memperbaikinya maka dipisahkan prodi menjadi tabel sendiri


**Tabel Mahasiswa**
| Nim | Nama |Program Studi|No Hp| Alamat |
| - | - |-|-|-|
| 1001 | Roni |Teknik Komputer|0823|Palembang|
| 1002 | Rino |Teknik Informatika|0821|Kayu Agung|
| 1003 | Indah|0822|Komputerisasi Akuntansi|Prabumulih|
| 1004 | Rian |0891|Teknik Komputer|Muara Dua|

---
**Tabel Mata Kuliah**
|Kode Matkul|Mata Kuliah|SKS|
|-|-|-|
|K-001|Pemrograman Web|3|
|K-002|Arsitektur Data |2|
|K-003|Komputasi Bergerak|4|
|K-004|Basis Data|3|
---
**Tabel Prodi**
|Program Studi | Jurusan |
|-|-|
|Teknik Komputer | Sistem Komputer|
|Teknik Informatika | Teknik Informatika|
| Komputerisasi Akuntansi | Sistem Informasi|

---
**Tabel Nilai (Tabel Mahasiswa - Mata Kuliah)**
|Nim|Kode Matkul|Nilai|
|-|-|-|
|1001|K-001|B|
|1002|K-002|A|
|1001|K-003|A|
|1003|K-004|A|
|1004|K-001|A|

---

## Desain Database
![Untitled Diagram](https://github.com/user-attachments/assets/acc41ec2-dc8e-4722-9a59-c49737ee0221)


