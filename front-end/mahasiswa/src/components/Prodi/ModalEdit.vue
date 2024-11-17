<template lang="">
    <div class="modal fade" id="editProdiModal" tabindex="-1" aria-labelledby="editProdiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProdiModalLabel">Edit Program Studi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="editProdi">
                <div class="mb-3">
                    <label for="prodi" class="form-label">Program Studi</label>
                    <input
                    type="text"
                    id="prodi"
                    class="form-control"
                    required
                    placeholder="Masukkan Program Studi"
                    v-model="prodiData.prodi"
                    />
                </div>

                <div class="mb-3">
                    <label for="studentJurusan" class="form-label">Jurusan</label>
                    <input
                    type="text"
                    id="studentJurusan"
                    class="form-control"
                    required
                    placeholder="Masukkan Jurusan"
                    v-model="prodiData.jurusan"
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

        }
    },
    props: ['prodiData'],
    methods: {
        editProdi() {
            const isProdiExist = this.prodiList.some(prodi => prodi.name === this.prodiData.prodi);

            if (isProdiExist) {
                this.errorMessage = 'Prodi sudah ada, gagal mengedit data.';
                this.showError();
                return;
            }

            this.$emit('edit-prodi', this.prodiData);

            this.prodi = '';
            this.jurusan = '';

            const modal = new bootstrap.Modal(document.getElementById('editProdiModal'));
            modal.hide();
        },
        showError() {
            Swal.fire({
                position: "center",
                icon: "error",
                title: this.errorMessage,
                showConfirmButton: false,
                timer: 1500
            });
        } 
    }
}
</script>
<style lang="">
    
</style>