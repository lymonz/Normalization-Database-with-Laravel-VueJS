<template lang="">
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Tambah Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="editMhs">
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
                        v-model="mhsData.nim"
                    />
                </div>
                <div class="mb-3">
                    <label for="studentName" class="form-label">Nama</label>
                    <input
                    type="text"
                    id="studentName"
                    class="form-control"
                    v-model="mhsData.nama"
                    required
                    placeholder="Masukkan nama mahasiswa"
                    />
                </div>
                <div class="mb-3">
                    <label for="prodi" class="form-label">Program Studi</label>
                    <select v-model="mhsData.prodi_id" class="form-select" id="prodi" required>
                        <option disabled value="" selected>Pilih Program Studi</option>
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
                        v-model="mhsData.no_hp"
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
                    v-model="mhsData.alamat"
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
import axios from 'axios';
export default {
    data() {
        return {
        prodilah: [],
        }
    },
    mounted() {
        this.fetchProdi();
    },
    props: ['mhsData'],
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
        editMhs() {
            this.$emit('edit-mhs', this.mhsData);

            this.nim = '';
            this.nama = '';
            this.prodi_id = '';
            this.no_hp = '';
            this.alamat = '';

            const modal = new bootstrap.Modal(document.getElementById('editStudentModal'));
            modal.hide();
        }
    }
}
</script>
<style lang="">
    
</style>