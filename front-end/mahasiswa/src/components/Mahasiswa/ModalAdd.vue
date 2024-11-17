<template lang="">
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Tambah Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="addMhs">
                <div class="mb-3">
                    <label for="studentNIM" class="form-label">NIM</label>
                    <input
                        type="number"
                        id="studentNIM"
                        class="form-control"
                        min="0"
                        step="1"
                        required
                        placeholder="Masukkan NIM Mahasiswa"
                        v-model="nim"
                    />
                </div>
                <div class="mb-3">
                    <label for="studentName" class="form-label">Nama</label>
                    <input
                    type="text"
                    id="studentName"
                    class="form-control"
                    v-model="nama"
                    required
                    placeholder="Masukkan nama mahasiswa"
                    />
                </div>
                <div class="mb-3">
                    <label for="prodi" class="form-label">Program Studi</label>
                    <select v-model="prodi_id" class="form-select" id="prodi" required>
                        <option disabled selected value="">Pilih Program Studi</option>
                        <option v-for="prodi in prodilah" :key="prodi.id" :value="prodi.id">{{ prodi.prodi }}</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="studentTelp" class="form-label">No. Telp</label>
                    <input
                        type="number"
                        id="studentTelp"
                        class="form-control"
                        min="0"
                        step="1"
                        required
                        v-model="no_hp"
                        placeholder="Masukkan Telp Mahasiswa"
                    />
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea
                    id="alamat"
                    class="form-control"
                    required
                    placeholder="Masukkan jurusan mahasiswa"
                    v-model="alamat"
                    />
                </div>
                <button class="btn btn-success w-100">Simpan</button>
                </form>
            </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios   from 'axios';
export default {
    // props: ['prodiData'],
    data() {
        return {
            nim:'',
            nama: '',
            prodi_id: '',
            no_hp: '',
            alamat : '',
            prodilah: [],
            // studentJurusan: '',
        }
    },
    
    mounted() {
        this.fetchProdi();
    },   
    methods: {
        fetchProdi() {
          const token = localStorage.getItem('token');
          axios.get('http://localhost:8000/api/index/prodi', {
            headers: {
              Authorization: `Bearer ${token}`
            }
          }).then(response => {
            this.prodilah = response.data.data;
            // console.log(this.prodilah);
            // console.log(this.prodilah.map(prodi => [prodi.prodi, prodi.id, prodi.jurusan]));
          }).catch(error => {
            console.error(error);
          })  
        },
        addMhs() {
            const mhsData = {
                nim: this.nim,
                nama: this.nama,
                prodi_id: this.prodi_id,
                no_hp: this.no_hp,
                alamat: this.alamat
            };

            this.$emit('add-mhs', mhsData);
            this.nim = '';
            this.nama = '';
            this.prodi_id = '';
            this.no_hp = '';
            this.alamat = '';            
            
            this.$swal({
                title: 'Success!',
                text: 'Prodi has been added successfully.',
                icon: 'success',
                confirmButtonText: 'Ok'
            }).then(() => {
                const modal = new bootstrap.Modal(document.getElementById('addStudentModal'));
                modal.hide();
                location.reload();
            }).catch(error => {
                if (error.response && error.response.status === 404) {
                    this.$swal({
                        title: 'Error!',
                        text: 'Prodi already exists.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                } else {
                    this.$swal({
                        title: 'Error!',
                        text: 'An unexpected error occurred.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        }   
    }
}
</script>
<style lang="">
    
</style>