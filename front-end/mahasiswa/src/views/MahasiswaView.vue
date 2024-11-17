<script setup>
import router from '../router';
import ModalAdd from '../components/Mahasiswa/ModalAdd.vue';
import ModalEdit from '../components/Mahasiswa/ModalEdit.vue';
import axios from 'axios';
</script>

<template lang="">

    <div class="container mt-4">
        <div class="row g-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="card-title fs-4 fw-bold">Daftar Mahasiswa</h5>
                            <button
                            class="btn btn-primary"
                            @click="showModal"
                            >
                            Tambah Mahasiswa
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
                                        <th scope="col" class="fw-bold">No. Telp</th>
                                        <th scope="col" class="fw-bold">Alamat</th>
                                        <th scope="col" class="fw-bold text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in mhsList" :key="data.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ data.nim }}</td>
                                        <td>{{ data.nama }}</td>
                                        <td>{{ data.prodis.prodi }}</td>
                                        <td>{{ data.prodis.jurusan }}</td>
                                        <td>{{ data.no_hp }}</td>
                                        <td>{{ data.alamat }}</td>
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

    <ModalAdd @add-mhs="handleAddMhs"/>
    <ModalEdit :mhsData="mhsToEdit" @edit-mhs="handleEditMhs" />

    
    
</template>

<script>
export default {
    components: { ModalAdd, ModalEdit },
    data() {
        return {
        mhsList: [],
        loading: false,
        error: null,
        mhsToEdit: [],
        mhsToDelete: [],
        };
    },
    mounted() {

        this.getMhs();
        // this.fetchProdi();

    },   
    methods: {
        async getMhs() {
            this.loading = true;
            this.error = null;
            try {
                const token = localStorage.getItem("token");

                const response = await axios.get(
                "http://localhost:8000/api/index/mahasiswa",
                {
                    headers: {
                    Authorization: `Bearer ${token}`,
                    },
                }
                );
                this.mhsList = response.data[0];
                // console.log(this.mhsList[0].prodi);
            } catch (error) {
                console.log(error);
                this.error = "Gagal memuat data program studi.";
            } finally {
                this.loading = false;
                this.$nextTick(() => {
                $("#mhsTable").DataTable({
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
        
        showModal() {
            const modal = new bootstrap.Modal(
                document.getElementById("addStudentModal")
            );
            modal.show();
        },
        async showModalEdit(id) {
            try {
                const token = localStorage.getItem("token");
                const response = await axios.get(
                `http://localhost:8000/api/index/mahasiswa/edit/${id}`,
                {
                    headers: {
                    Authorization: `Bearer ${token}`,
                    },
                }
                );
                this.mhsToEdit = response.data[0];
                const prodiName = this.mhsToEdit.prodis.prodi;

                console.log(response);
                const modal = new bootstrap.Modal(
                document.getElementById("editStudentModal")
                );
                modal.show();
            } catch (error) {    
                console.log(error);
            }
            const modal = new bootstrap.Modal(
                document.getElementById("editStudentModal")
            );
            modal.show();
        },
        async handleAddMhs(storeData) {
            this.mhsList.push(storeData);
            try {
                const token = localStorage.getItem("token");
                const response = await axios.post(
                "http://localhost:8000/api/index/mahasiswa/store",
                storeData,
                {
                    headers: {
                    Authorization: `Bearer ${token}`,
                    },
                }
                );

                console.log("Data Mahasiswa berhasil ditambahkan:");
            } catch (error) {
                console.error(
                "Terjadi kesalahan saat menambahkan program studi:",
                error
                );
            }
        },
        handleEditMhs(updateData) {
            const token = localStorage.getItem("token");
        if (token) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        }
        axios
            .put(
            `http://localhost:8000/api/index/mahasiswa/update/${updateData.id}`,
            updateData
            )
            .then((response) => {
            const index = this.mhsList.findIndex(
                (mhs) => mhs.id === updateData.id
            );
            if (index !== -1) {
                this.mhsList[index] = { ...updateData };
            }
            const modal = new bootstrap.Modal(
                document.getElementById("editStudentModal")
            );
            modal.hide();

            this.$swal({
                position: "center",
                icon: "success",
                title: "Data berhasil diperbarui",
                showConfirmButton: false,
                timer: 1500,
            });
            })
            .catch((error) => {
            console.error("Error updating data:", error);
            });
            
            },
            async showConfirmDelete(id) {
                try {
                    const token = localStorage.getItem("token");
                    const response = await axios.get(
                    `http://localhost:8000/api/index/mahasiswa/${id}`,
                    {
                        headers: {
                        Authorization: `Bearer ${token}`,
                        },
                    }
                    );
                    this.mhsToDelete = response.data[0]
                    // console.log(this.mhsToDelete);
                    
                    this.$swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: `Data mahasiswa atas nama ${this.mhsToDelete.nama} akan dihapus secara permanen!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.handleDeleteMhs(id);
                        }
                    })
                } catch (error) {
                    console.log(error);
                }
                
            },
            handleDeleteMhs(id) {
                const token = localStorage.getItem("token");
                if (token) {
                    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
                }
                axios.delete(`http://localhost:8000/api/index/mahasiswa/destroy/${id}`)
                .then(() => {
                    const index = this.mhsList.findIndex((mhs) => mhs.id === id);
                    if (index !== -1) {
                    this.mhsList.splice(index, 1);
                    }
                    this.$swal({
                    position: "center",
                    icon: "success",
                    title: "Data berhasil dihapus",
                    showConfirmButton: false,
                    timer: 1500,
                    }).then(() => {
                        window.location.reload();
                    });
                })
                .catch((error) => {
                    console.error("Error deleting data:", error);
                });
            },
    },
}
</script>
<style lang="">
    
</style>