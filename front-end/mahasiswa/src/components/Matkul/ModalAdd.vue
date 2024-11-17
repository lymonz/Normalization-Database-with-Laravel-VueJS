<template lang="">
    <div class="modal fade" id="addMatkulModal" tabindex="-1" aria-labelledby="addMatkulModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMatkulModalLabel">Tambah Mata Kuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="addMatkul">
                <div class="mb-3">
                    <label for="kodeMk" class="form-label">Kode Mata Kuliah</label>
                    <input
                    type="text"
                    id="kodeMk"
                    class="form-control"
                    required
                    placeholder="Masukkan Kode Mata Kuliah"
                    v-model="kode_matkul"
                    />
                </div>

                <div class="mb-3">
                    <label for="matakuliah" class="form-label">Mata Kuliah</label>
                    <input
                    type="text"
                    id="matakuliah"
                    class="form-control"
                    required
                    placeholder="Masukkan Mata Kuliah"
                    v-model="mata_kuliah"
                    />
                </div>

                <div class="mb-3">
                    <label for="sks" class="form-label">SKS</label>
                    <input
                    type="number"
                    @input="limitLength"
                    id="sks"
                    class="form-control"
                    required
                    placeholder="Masukkan Jumlah SKS"
                    v-model="sks"
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
export default {
    data() {
        return {
            kode_matkul: '',
            mata_kuliah: '',
            sks: ''
        }
    },
    methods: {
        limitLength(event) {
            const value = event.target.value;

            
            if (value.length > 1) {
                this.sks = value.slice(0, 1);
            }
        },
        addMatkul() {
            const matkulData = {
                kode_matkul: this.kode_matkul,
                mata_kuliah: this.mata_kuliah,
                sks: this.sks
            }
            this.$emit('add-matkul', matkulData)
            this.kode_matkul = ''
            this.mata_kuliah = ''
            this.sks = ''

            this.$swal({
                title: 'Success!',
                text: 'Matkul has been added successfully.',
                icon: 'success',
                showConfirmButton: false,
                timer: 1000
            }).then(() => {
                const modal = new bootstrap.Modal(document.getElementById('addMatkulModal'))
                modal.hide()
                location.reload();
            })
        }
    }
}
</script>
<style lang="">
    
</style>