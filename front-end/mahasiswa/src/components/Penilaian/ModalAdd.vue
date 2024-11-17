<template lang="">
    <div class="modal fade" id="addNilaiModal" tabindex="-1" aria-labelledby="addNilaiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNilaiModalLabel">Tambah Penilaian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="addNilai">
                <div class="mb-3">
                    <label for="studentNIM" class="form-label">NIM</label>
                    <select class="form-select" v-model="mhs_id" required>
                        <option disabled selected value="">Select NIM</option>
                        <option v-for="mhs in mahasiswalah" :key="mhs.id" :value="mhs.id">{{ mhs.nim }} - {{ mhs.nama }} - {{ mhs.prodis.prodi }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    Keterangan :

                </div>
                <div class="mb-3">
                    <label for="prodi" class="form-label">Kode Mata Kuliah</label>
                    <select v-model="matkul_id" class="form-select" id="prodi" required>
                        <option disabled selected value="">Pilih Kode Mata Kuliah</option>
                        <option v-for="matkul in matkulah" :key="matkul.id" :value="matkul.id">{{ matkul.kode_matkul }} - {{ matkul.mata_kuliah }}</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nilai" class="form-label">Nilai</label>
                    <input
                    type="text"
                    id="nilai"
                    class="form-control"
                    required
                    placeholder="Masukkan Nilai"
                    v-model="nilai"
                    @input="limitLength"
                    maxlength="1"
                    oninput="this.value = this.value.toUpperCase()"
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
            mhs_id: '',
            matkul_id: '',
            nilai: '',
            mahasiswalah: [],
            matkulah: [],
            // studentJurusan: '',
        }
    },
    
    mounted() {
        this.fetchMahasiswa();
        this.fetchKodeMatkul();
    },   
    methods: {
        limitLength() {
            if (this.nilai.length > 1) {
                this.nilai = this.nilai.toUpperCase().slice(0, 1);
                
            }
        },
        fetchMahasiswa() {
          const token = localStorage.getItem('token');
          axios.get('http://localhost:8000/api/index/mahasiswa', {
            headers: {
              Authorization: `Bearer ${token}`
            }
          }).then(response => {
            this.mahasiswalah = response.data[0];
            // console.log(this.mahasiswalah);
            // console.log(this.prodilah.map(prodi => [prodi.prodi, prodi.id, prodi.jurusan]));
          }).catch(error => {
            console.error(error);
          })  
        },
        fetchKodeMatkul() {
            const token = localStorage.getItem('token');
            axios.get('http://localhost:8000/api/index/matkul', {
                headers: {
                Authorization: `Bearer ${token}`
                }
            }).then(response => {
                this.matkulah = response.data.data;
                // console.log(this.matkulah);
                // console.log(this.prodilah.map(prodi => [prodi.prodi, prodi.id, prodi.jurusan]));
            }).catch(error => {
                console.error(error);
            })  
        },
        addNilai() {
            const nilaiData = {
                mhs_id : this.mhs_id,
                matkul_id: this.matkul_id,
                nilai: this.nilai
            };

            this.$emit('add-nilai', nilaiData);
            this.mhs_id = '';
            this.matkul_id = '';
            this.nilai = '';
            
            this.$swal({
                title: 'Success!',
                text: 'Prodi has been added successfully.',
                icon: 'success',
                showConfirmButton: false,
                timer: 1000
            }).then(() => {
                const modal = new bootstrap.Modal(document.getElementById('addNilaiModal'));
                modal.hide();
                location.reload();
            }).catch(error => {
                if (error.response && error.response.status === 404) {
                    this.$swal({
                        title: 'Error!',
                        text: 'Prodi already exists.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    this.$swal({
                        title: 'Error!',
                        text: 'An unexpected error occurred.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }   
    }
}
</script>
<style lang="">
    
</style>