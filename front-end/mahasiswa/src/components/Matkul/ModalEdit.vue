<template lang="">
    <div class="modal fade" id="editMatkulModal" tabindex="-1" aria-labelledby="editMatkulModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMatkulModalLabel">Edit Mata Kuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="editMatkul">
                <div class="mb-3">
                    <label for="kodeMk" class="form-label">Kode Mata Kuliah</label>
                    <input
                    type="text"
                    id="kodeMk"
                    v-model="matkulData.kode_matkul"
                    class="form-control"
                    required
                    placeholder="Masukkan program studi"
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
                    v-model="matkulData.mata_kuliah"
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
                    v-model="matkulData.sks"
                    />
                </div>
                <button type="submit" class="btn btn-success w-100">Simpan</button>
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

        }
    },
    props: ['matkulData'],
    methods: {
        limitLength(event) {
            const value = event.target.value;

            
            if (value.length > 1) {
                this.sks = value.slice(0, 1);
            }
        },
        editMatkul() {
            this.$emit('edit-matkul', this.matkulData)
            this.kode_matkul = ''
            this.mata_kuliah = ''
            this.sks = ''

            const modal = new bootstrap.Modal(document.getElementById('editMatkulModal'))
            modal.hide()
        }


    }   
}
</script>
<style lang="">
    
</style>