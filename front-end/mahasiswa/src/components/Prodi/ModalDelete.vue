
<template lang="">
    <div
        class="modal fade"
        id="confirmDeleteModal"
        tabindex="-1"
        aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="confirmDeleteModalLabel">
                Konfirmasi Hapus
            </h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
            </div>
            <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus program studi:</p>
            <p class="fw-bold">{{ prodiToDelete?.prodi }}</p>
            </div>
            <div class="modal-footer">
            <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
            >
                Batal
            </button>
            <button
                type="button"
                class="btn btn-danger"
                @click="confirmDelete"
            >
                Hapus
            </button>
            </div>
        </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        prodiToDelete: {
            type: Object,
            default: null,
        },
    },
    methods: {
        confirmDelete() {
        this.$emit('delete-prodi', this.prodiToDelete.id);
        },
    },
}
</script>
<style lang="">
    
</style>