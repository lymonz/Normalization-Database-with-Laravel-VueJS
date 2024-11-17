<script setup>
import axios from "axios";
import ModalAdd from "../components/Penilaian/ModalAdd.vue";
import ModalEdit from "../components/Penilaian/ModalEdit.vue";
</script>
<template lang="">

    <div class="container mt-4">
        <div class="row g-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="card-title fs-4 fw-bold">Daftar Penilaian</h5>
                            <button
                            class="btn btn-primary"
                            @click="showModal"
                            >
                            Tambah Penilaian
                            </button>
                        </div>
                        <div v-if="loading" class="text-center">
                        <p>Loading...</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="mhsTable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="fw-bold">No</th>
                                        <th scope="col" class="fw-bold">NIM</th>
                                        <th scope="col" class="fw-bold">Nama</th>
                                        <th scope="col" class="fw-bold">Program Studi</th>
                                        <th scope="col" class="fw-bold">Jurusan</th>
                                        <th scope="col" class="fw-bold">Kode Mata Kuliah</th>
                                        <th scope="col" class="fw-bold">Mata Kuliah</th>
                                        <th scope="col" class="fw-bold text-center">Nilai</th>
                                        <th scope="col" class="fw-bold text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in nilaiList" :key="data.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ data.mahasiswas.nim }}</td>
                                        <td>{{ data.mahasiswas.nama }}</td>
                                        <td>{{ data.mahasiswas.prodis.prodi }}</td>
                                        <td>{{ data.mahasiswas.prodis.jurusan }}</td>
                                        <td>{{ data.matkuls.kode_matkul }}</td>
                                        <td>{{ data.matkuls.mata_kuliah }}</td>
                                        <td class="text-center">{{ data.nilai }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <button
                                                class="btn btn-success me-2"
                                                @click="showModalEdit(data.id)"
                                                >
                                                <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button class="btn btn-danger" @click="showConfirmDelete(data.id)">
                                                <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-if="error" class="alert alert-danger mt-3">
                                {{ error }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ModalAdd @add-nilai="handleAddNilai"/>
    <ModalEdit :nilaiData="nilaiToEdit" @edit-nilai="handleEditNilai" />

    
    
</template>
<script>

export default {
    components: { ModalAdd, ModalEdit },
    data() {
        return {
            nilaiList: [],
            loading: false,
            error: null,
            nilaiToEdit: [],
            nilaiToDelete: []
        }
    },

    mounted() {
        this.getNilaiList();
    },

    methods: {
        async getNilaiList() {
            this.loading = true;
            this.error = null;

            try {
                const token = localStorage.getItem("token");

                const response = await axios.get(
                "http://localhost:8000/api/index/nilai",
                {
                    headers: {
                    Authorization: `Bearer ${token}`,
                    },
                }
                );
                this.nilaiList = response.data.data;
            } catch (error) {
                console.log(error);
                this.error = "Gagal memuat data program studi.";
            } finally {
                this.loading = false;
                this.$nextTick(() => {
                $("#prodiTable").DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    pageLength: 5,
                    lengthMenu: [5, 10, 25, 50, 100],
                    responsive: true,
                    destroy: true,
                });
                });
            }
        },
        showModal(){
            const modal = new bootstrap.Modal(
                document.getElementById("addNilaiModal")
            );
            modal.show();
        },

        async handleAddNilai(storeData) {
            // this.nilaiList.push(storeData);
            try {
                const token = localStorage.getItem("token");
                const response = await axios.post(
                "http://localhost:8000/api/index/nilai/store",
                storeData,
                {
                    headers: {
                    Authorization: `Bearer ${token}`,
                    },
                }
                );

                console.log("Data Nilai berhasil ditambahkan:");
            } catch (error) {
                console.error(
                "Terjadi kesalahan saat menambahkan Nilai:",
                error
                );
            }
        // console.log("Data Prodi Berhasil Ditambah:", storeData);
        },


        async showConfirmDelete(id) {
            try {
                const token = localStorage.getItem("token");
                const response = await axios.get(
                `http://localhost:8000/api/index/nilai/${id}`,
                {
                    headers: {
                    Authorization: `Bearer ${token}`,
                    },
                }
                );
                this.nilaiToDelete = response.data.data;
                
                this.$swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: `Penilaian mahasiswa atas nama ${this.nilaiToDelete.mahasiswas.nama} akan dihapus secara permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.handleDeleteNilai(id);
                    }
                })
            } catch (error) {
                console.log(error);
            }
            
        },

        handleDeleteNilai(id) {
            const token = localStorage.getItem("token");
            if (token) {
                axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
            }
            axios.delete(`http://localhost:8000/api/index/nilai/destroy/${id}`)
            .then(() => {
                const index = this.nilaiList.findIndex((nilai) => nilai.id === id);
                if (index !== -1) {
                this.nilaiList.splice(index, 1);
                }
                this.$swal({
                position: "center",
                icon: "success",
                title: "Data berhasil dihapus",
                showConfirmButton: false,
                timer: 1500,
                }).then(() => {
                    window.location.reload();
                }).catch(error => {
                    window.location.reload();
                });
            })
            .catch((error) => {
                console.error("Error deleting data:", error);
                window.location.reload();
            });
        },

        async showModalEdit(id) {
            try {
                const token = localStorage.getItem("token");
                const response = await axios.get(
                `http://localhost:8000/api/index/nilai/${id}`,
                {
                    headers: {
                    Authorization: `Bearer ${token}`,
                    },
                }
                );
                this.nilaiToEdit = response.data.data;
                const modal = new bootstrap.Modal(
                document.getElementById("editNilaiModal")
                );
                modal.show();

            } catch (error) {
                console.log(error);
            }
        },

        handleEditNilai(updateData) {
            const token = localStorage.getItem("token");
            if (token) {
                axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
            }
            axios
                .put(
                `http://localhost:8000/api/index/nilai/update/${updateData.id}`,
                updateData
                )
                .then((response) => {
                    const index = this.nilaiList.findIndex(
                        (mhs_id) => mhs_id.id === updateData.id
                    );
                    if (index !== -1) {
                        this.nilaiList[index] = { ...updateData };
                    }
                    const modal = new bootstrap.Modal(
                        document.getElementById("editNilaiModal")
                    );
                    modal.hide();

                    this.$swal({
                        position: "center",
                        icon: "success",
                        title: "Data berhasil diperbarui",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => window.location.reload())
                    .catch(error => {
                        window.location.reload();
                    });
                })
                .catch((error) => {
                console.error("Error updating data:", error);
                });
        },


    }
}
</script>
<style lang="">
    
</style>