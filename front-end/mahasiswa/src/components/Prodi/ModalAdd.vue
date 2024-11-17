<template lang="">
    <div class="modal fade" id="addProdiModal" tabindex="-1" aria-labelledby="addProdiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProdiModalLabel">Tambah Program Studi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="addProdi">
                <div class="mb-3">
                    <label for="prodi" class="form-label">Program Studi</label>
                    <input
                    type="text"
                    id="prodi"
                    class="form-control"
                    required
                    placeholder="Masukkan Nama Program Studi"
                    v-model="prodi"
                    />
                </div>

                <div class="mb-3">
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <input
                    type="text"
                    id="jurusan"
                    class="form-control"
                    required
                    placeholder="Masukkan Nama Jurusan"
                    v-model="jurusan"
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
            prodi: '',
            jurusan: ''
        }
    },
    mounted() {
        this.username = localStorage.getItem('token')
        if(!this.username || this.username == '') {
            router.push({name:'login'});
        }
    },   
    methods: {
        addProdi() {
            const prodiData = {
                prodi: this.prodi,
                jurusan: this.jurusan
            };

            this.$emit('add-prodi', prodiData);
            this.prodi = '';
            this.jurusan = '';
            
            this.$swal({
                title: 'Success!',
                text: 'Prodi has been added successfully.',
                icon: 'success',
                confirmButtonText: 'Ok'
            }).then(() => {
                const modal = new bootstrap.Modal(document.getElementById('addProdiModal'));
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